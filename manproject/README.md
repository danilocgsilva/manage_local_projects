# `manproject` folder

* `__main__.py`: The file that will be called by command line. The main file/entry point.
* `commands_bag.py`: A *container* that groups fundamental data for businesses rule, holding a help text and the business rule code itself. The main content is a single dict, so with this easy, it is easy to loop through all commands and prints all possibilities at once.
* `functions.py`: a *generic file* to support logic for `commands_bag.py`, when a logic is not possible to be put in a single lambda function or when there is not much clear who have the responsability to hold the logic (seeking the single responsability principle).
* `Project.py`: Object to facilitates the project data management. Instantiate it with the project name.
* `ProjectConfig.py`: Have responsabilities over the configuration storage (currently, a bare json file).
* `Sync.py`: Syncronizes data between storage directory and working directory.