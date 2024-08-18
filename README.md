## Dataverse Assessment

This is my attempt at creating a user administration tool.

## Project Breakdown
As requested, the application supports user, role and permission CRUD operations using Ajax. Users have roles which in turn have permissions. The level of access in the application is determined by the roles a user has and what permissions those roles have.
## Create Dummy Data Command
- run ./vendor/bin/sail artisan one-time:create-dummy-data
- Select how many dummy user will be created (default: 100)
- Provide username for simple user (default: user)
- Provide password for simple user (default: password)
- Provide username for admin user (default: admin)
- Provide password for admin user (default: admin)
