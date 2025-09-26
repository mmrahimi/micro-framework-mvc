# PHP Micro Framework Built on MVC

A slim PHP framework that has a lot of features you would expect from an MVC framework.

> 🟡 Through this project i learned the basics of how a modern MVC-based backend framework functions. REBUILT OLD PROJECT

## 🔧 Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/mmrahimi/micro-framework-mvc
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```
   
3. **Configure environment**
  - Copy `.env.example` to `.env`
  - Set your DB and hosting credentials (by default it's set to localhost and the path to the framework)

4. **Use Apache (not PHP's built-in server)**
  - This framework relies on .htaccess for routing, so make sure you're running it under Apache with mod_rewrite enabled.
  - Place the project inside your Apache root (e.g., htdocs/micro-framework-mvc)
  - Start Apache via XAMPP or your preferred setup

## 📦 Features
- Custom routing with .htaccess and regex-based URI matching
- MVC structure with controller/action dispatching
- A complete DB interface to query models
- Middlewares
