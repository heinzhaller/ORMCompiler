# ORMCompiler
## Author: Mario Kaufmann
### Version: 0.2 beta

## 1. Installation ORMCompiler
 - Checkout/Clone Compiler to **/var/www/**
 - Create new apache2-vhosts like "ormcompiler.mydomain.tld"
 
## 2. Create new project
 - Copy Folder "mvc" (inside ormcompiler folder) to **/var/www/** and rename it as your new project folder
 - Create new apache2-vhosts like "mydomain.tld"
 - Run ORMCompiler from http like "ormcompiler.mydomain.tld/setup.php"
 - Define "Paths" for Application, Abstraction and System your new project like "/var/www/myProject/application/global/" (we recommend to use for all same folder called **global** inside the new mvc application folder)
 - Click "Build and save config" to generete all ORM related files -> Finish
 
## 3. Project updates
 - Run ORMCompiler from http like "ormcompiler.mydomain.tld/setup.php"
 - Click "Build and save config" to generete all ORM related files -> Finish (only Base-Files are overwritten by compiler!)
 
## Optional [test database]
 - Create new database from "db.test.sql" (inside ormcompiler folder)
 - Run ORMCompiler