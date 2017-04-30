# Webshop SQL api

## Cart
The cart is managed with three procedures **addToCart()**, **removeFromCart()** and **getCart()**.

#### addToCart(cartID, productID, amount)
Add a product to a cart.

##### Parameters
**cartID**
The id of the cart to add products to. If the id does not exist a new cart is created.
**productID**
The id of the product to add to the cart.
**amount**
The amount of products to add to the cart.

#### removeFromCart(cartID, productID, amount)
Remove a product from the cart.
##### Parameters
**cartID**
The id of the cart to remove products from.
**productID**
The id of the product to remove from the cart.
**amount**
The amount of products to remove from the cart.

#### getCart(cartID)
Display the content of a cart.

##### Parameters
**cartID**
The id of the cart to display.

---

## Order
The order is managed with three procedures **createOrder()**, **deleteOrder()** and **getOrder()**.

#### createOrder(cartID, userID)
Create an order connected to an user.

##### Parameters
**cartID**
The id of the cart to create the order from.
**userID**
The id of the user to connect the order to.

#### deleteOrder(orderID)
Deletes and order by setting a timestamp. Also returns the products to the inventory.
##### Parameters
**orderID**
The id of the order to delete.

#### getOrder(orderID)
Display the details and products of an order.

##### Parameters
**orderID**
The id of the order to display.

---

## Inventory log
The order is managed with a trigger and displayed with the procedure **getInventoryLog()**.

When a products inventory gets updated the **LogInventory** trigger is triggered. If the new amount is below 5 a row is inserted into the **InventoryLog** table

#### getInventoryLog()
Display a list of products that got an inventory below 5.
