<?php
// add-to-cart.php - Updated
session_start();
include('includes/connection.php');

header('Content-Type: application/json');

// Get request data
$book_id = isset($_POST['book_id']) ? (int)$_POST['book_id'] : 0;
$action = isset($_POST['action']) ? $_POST['action'] : 'add';
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

if($book_id <= 0) {
    echo json_encode([
        'success' => false, 
        'message' => 'Invalid book ID'
    ]);
    exit;
}

// Check if book exists
$book_query = "SELECT book_id, title, price, cover_image, is_free_for_members FROM books WHERE book_id = $book_id";
$book_result = mysqli_query($con, $book_query);

if(mysqli_num_rows($book_result) == 0) {
    echo json_encode([
        'success' => false, 
        'message' => 'Book not found'
    ]);
    exit;
}

$book = mysqli_fetch_assoc($book_result);

// Initialize cart session if not exists
if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [
        'items' => [],
        'subtotal' => 0,
        'total_items' => 0,
        'session_id' => session_id()
    ];
}

// Handle different actions
switch($action) {
    case 'add':
        // Check if book already in cart
        $found = false;
        foreach($_SESSION['cart']['items'] as &$item) {
            if($item['book_id'] == $book_id) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        
        // If not found, add new item
        if(!$found) {
            $_SESSION['cart']['items'][] = [
                'book_id' => $book_id,
                'title' => $book['title'],
                'price' => $book['price'],
                'cover_image' => $book['cover_image'],
                'quantity' => $quantity,
                'is_free' => ($book['price'] == 0 || $book['is_free_for_members'] == 1)
            ];
        }
        
        // Update cart totals
        update_cart_totals();
        
        echo json_encode([
            'success' => true,
            'message' => 'Item added to cart',
            'cart_count' => $_SESSION['cart']['total_items'],
            'cart_total' => $_SESSION['cart']['subtotal']
        ]);
        break;
        
    case 'remove':
        // Remove item from cart
        $_SESSION['cart']['items'] = array_filter($_SESSION['cart']['items'], function($item) use ($book_id) {
            return $item['book_id'] != $book_id;
        });
        
        // Re-index array
        $_SESSION['cart']['items'] = array_values($_SESSION['cart']['items']);
        
        update_cart_totals();
        
        echo json_encode([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_count' => $_SESSION['cart']['total_items'],
            'cart_total' => $_SESSION['cart']['subtotal']   
        ]);
        break;
        
    case 'update':
        // Update quantity
        foreach($_SESSION['cart']['items'] as &$item) {
            if($item['book_id'] == $book_id) {
                $item['quantity'] = $quantity;
                break;
            }
        }
        
        update_cart_totals();
        
        echo json_encode([
            'success' => true,
            'message' => 'Cart updated',
            'cart_count' => $_SESSION['cart']['total_items'],
            'cart_total' => $_SESSION['cart']['subtotal']
        ]);
        break;
        
    case 'clear':
        // Clear cart
        $_SESSION['cart'] = [
            'items' => [],
            'subtotal' => 0,
            'total_items' => 0,
            'session_id' => session_id()
        ];
        
        echo json_encode([
            'success' => true,
            'message' => 'Cart cleared',
            'cart_count' => 0,
            'cart_total' => 0
        ]);
        break;
        
    default:
        echo json_encode([
            'success' => false, 
            'message' => 'Invalid action'
        ]);
}

// Function to update cart totals
function update_cart_totals() {
    $subtotal = 0;
    $total_items = 0;
    
    foreach($_SESSION['cart']['items'] as $item) {
        if(!$item['is_free']) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $total_items += $item['quantity'];
    }
    
    $_SESSION['cart']['subtotal'] = $subtotal;
    $_SESSION['cart']['total_items'] = $total_items;
}
?>