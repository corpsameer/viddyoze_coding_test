## Widget shopping cart application

This application is an online shopping cart where a user can buy widgets as per their business needs. The user can avail benefits of offers that are available on selected products. Based on total value of cart, there are discounts on delivery charges that are offered to customer.

## Architecture

- Backend - PHP (CodeIgniter MVC framework).
- Frontend -  HTML, CSS, Bootstrap and JavaScript.
- Database - MySQL.
- Client side interaction - JavaScript and JQuery.

## How to run the application

- Database setup
  * Create a new database in MySQL and name it viddyoze (choose the username and password that you want to set for the database).
  * Upload the database dump provided with the application.
  * If you have added the database to a user other than root, make the required changes in database.php file under config.

- Running the application
  * Clone the git repository in your root directory - https://github.com/corpsameer/viddyoze_coding_test.git
  * Make the changes in database.php file if required.
  * Open your browser and visit your server root. You should see home page of the application with list of products.

## Pages in application

- Home/Shop - Product list with option to add product to cart.
- Offers - List of active offers in the application.
- Shopping cart - Cart with customer's selected products, their total price, applicable delivery charges, option to remove a product from   cart and option to place order.
- Confirmation - Shows details of successful order placed by customer.
- Login - Customer account login functionality.
- Signup - Create new customer account functionality.

## Application flow

- User visits the application home page and sees list of products along with applicable offers if any, on the product.
- Only a logged in user can add products to cart or see products in the cart.
- User clicks the login button in header.
- If user is already registered, he logs in to the application with his email and password.
- If he is a new user, he clicks on create account and enters his account details.
- After user is logged in, he visits the shop page and adds products he wants to his cart as per desired quantity.
- If product is added to cart, user is alerted with a success message and the count is update in header cart icon.
- After user has added all products he desires to the cart, he visits the shopping cart page.
- The user sees list of all products in the cart with details like quantity, price, offer applied and total price of the product.
- The user has an option to delete any product from the cart below name of each product in the cart.
- The user can see the subtotal of all the products in cart and applicable delivery charges.
- The user clicks proceed to checkout button to place on order.
- The checkout functionality validates if price and applicable offer on each product is still active. If all validations pass,
the order is placed successfully and user is shown order confirmation page with order details.
