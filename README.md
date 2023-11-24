# Manage local pojects

* Project registration
* Project removal
* Environment registration
* Credentials registration
* Database credential registration

## Git address registration

The remote git address for the project.

## An environment can belongs to a project

And an environment can have several projects.

## Project registration

A project can be of two types:

* Normal: a normal project
* Database: a database project

A normal project should hold a property, which is its url in production.

## Environment registration

Can be a *computer*, or a node where project data exists. A project can have several environments.

## Database credentials registration

Users, password and anything else required to access an environment or system. The registration should belongs to an environment. But may also may belongs to a project as well at the same time. The credential (usually, from a database) is closely tied to the environment itself. But a project, through the environment, may access and may own the data from the database acessible by credentials. An environment may have several database crdentials. But database credentials cannot belongs to several environment at the same time.

## Deploys

A deloy is a sum of some receipts and the environment. Basically, is the two parts required to have a running application. Sometimes, a deploy may need several receipt, for example, some for backend and antoher for frontend building, so a deploy may depends upon several receipts at the same time. A deploymant also may require several environments to work. For example, a server for database and another for the application. So a single deploy may require several environments as well. And finally, a deploy must belongs to a project. A same project may have several deployments (as an example, one for local development, another for QA and the production environment), but a deploy may belongs to just one Project.
