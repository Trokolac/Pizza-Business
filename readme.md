# Pizza Business 

This is web application for browsing selecting and ordering pizza

App contains:

-login/register;
-admin panel;
-admin only add pizzas to the menu/piza name, description, price and upload image;
-adding to cart pizza from menu;
-cart that calculates sum of all pizza in cart/form to collect data/available update quantity;
-order button sends mail to pizza shop/empty cart after order by updating deleted at column to time now();
-history page that shows all ordered pizza buy user.

Problems i had:

-heroku platform doesnt come with MySql (i did learn to add that via addons "ClearDB MySql");
-heroku doesnt handle sending mail via php mail(); function, there is addon for that called SendGrid whichi didnt have time to implement, also there is little learning curve there unlike with setting up MySql on heroku;
-i dont know how to implement currency change in real time so that it is dinamic.

Because i had little problems on heroku i did upload my web app to another platform called 000webhost

url link to that web app is https://onlyfortestingwebsite.000webhostapp.com

To access admin panel credentials are:

-admin@shop.com -> email
-123 -> password

Graphics done by Katarina Lazic url link https://www.lazickatarinacportfolio.com    


