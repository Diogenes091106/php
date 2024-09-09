<?php
session_start();

// ítem no carrinho
function addItemToCart($item_id, $quantity) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$item_id])) {
        $_SESSION['cart'][$item_id] += $quantity;
    } else {
        $_SESSION['cart'][$item_id] = $quantity;
    }
}

// remover um item do carrinho
function removeItemFromCart($item_id) {
    if (isset($_SESSION['cart'][$item_id])) {
        unset($_SESSION['cart'][$item_id]);
    }
}

// mostrar o carrinho
function showCart() {
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    $output = "<h2>Carrinho de Compras</h2><ul>";
    foreach ($cart as $item_id => $quantity) {
        $output .= "<li>Item ID: $item_id - Quantidade: $quantity 
                    <a href='?action=remove&item_id=$item_id'>Remover</a></li>";
    }
    $output .= "</ul><a href='?action=clear'>Limpar Carrinho</a>";
    return $output;
}

// Processar as ações
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action === 'add' && isset($_GET['item_id']) && isset($_GET['quantity'])) {
        $item_id = intval($_GET['item_id']);
        $quantity = intval($_GET['quantity']);
        addItemToCart($item_id, $quantity);
    } elseif ($action === 'remove' && isset($_GET['item_id'])) {
        $item_id = intval($_GET['item_id']);
        removeItemFromCart($item_id);
    } elseif ($action === 'clear') {
        unset($_SESSION['cart']);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Carrinho de Compras</title>
</head>
<body>
    <h1>Bem-vindo ao Carrinho de Compras</h1>
    <h2>Adicionar Itens</h2>
    <form method="get" action="">
        <label for="item_id">ID do Item:</label>
        <input type="text" id="item_id" name="item_id" required>
        <label for="quantity">Quantidade:</label>
        <input type="text" id="quantity" name="quantity" required>
        <input type="hidden" name="action" value="add">
        <button type="submit">Adicionar ao Carrinho</button>
    </form>
    
    <?php echo showCart(); ?>
</body>
</html>
