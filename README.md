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

Can be a *computer*, or a node where project data exists.

## Credentials registration

Users, password and anything else required to access an environment or system. The registration should belongs to an environment. But may also may belongs to a project as well at the same time. The credential (usually, from a database) is closely tied to the environment itself. But an project, through the environment, may access and may own the datata from the database acessible by credentials. An environment may have several database crdentials. But database credentials cannot belongs to several environment at the same time.
