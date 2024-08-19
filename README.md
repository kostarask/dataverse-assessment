## Dataverse Assessment

This is my attempt at creating a user administration tool.

## Project Breakdown
As requested, the application supports user, role and permission CRUD operations using Ajax. Users have roles which in turn have permissions. The level of access in the application is determined by the roles a user has and what permissions those roles have.

## Installation

### Step 1.
Clone this repository and install all Composer dependencies.
```
git clone git@github.com:kostarask/dataverse-assessment.git
cd dataverse-assessment
composer install
```

### Step 2.
Rename or Copy .env.example file to .env and generate application key.
```
cp .env.example .env
```

### Step 3.
Start docker with sail
```
./vendor/bin sail up
```

### Step 4.
Migrate database
```
sail artisan migrate
```

### Step 5.
Create dummy users, simple and admin user
```
sail artisan one-time:create-dummy-data

Choose:
    -Number of dummy users (default: 100)
    -Username of simple user (default: "user")
    -Password of simple user (default: "password")
    -Username of admin user (default: "admin")
    -Password of admin user (default: "admin")

Simple user has no permissions
Admin user has all permissions
```
