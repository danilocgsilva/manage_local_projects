# Manage Projects

This utility still is in a very early development stage, so it still in a WIP state.

## How to use

### 1. Install

You must have `python` and `pip` working and acessible int yours computer command line.

if so:

1. Go to the root project folder
2. Just type: `pip install .`

### 2. Use

You can access the command utility through tiping `mpro`.

Type `mpro help` to see all commands.

## Some concepts

* Working Directory: where you will *work*, or will *code* in the local machine and, potentially, is read by the local service during local development.
* Storage directory: where you would like to *storage* your code after some work done. For example, a directory inside your Dropbox that will be atomatically synced throughout your sync service and have code safe.

**Why?**

Having your code in a local folder, and being the place to be read by the local service and at same time be a safe place to storage may not be always possible. So the idea is that you have those two different locations easily changing and updating each other, depending if you are coding or storaging your code project. Just to reinforce:

* *Working Directory* is where you will have your files during the development
* *Storage Directory* is where you will *storage* your stuffs after some work (a *commit).

## Files created locally to make stuffs works

`~/.mpro`: a json file containing the projects data.
`~/.mpro_envs`: a json file containing information about environments.
