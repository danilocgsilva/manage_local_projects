from manproject.Project import Project
import os

class Sync:

    def __init__(self, project: Project):
        self.project = project

    def to_storage(self):
        os_command = "rsync -rv " + self.__get_working_dir() + "/ " + self.__get_storage_dir() + "/"
        os.system(os_command)
        
    def to_working(self):
        os_command = "rsync -rv " + self.__get_storage_dir() + "/ " + self.__get_working_dir() + "/"
        os.system(os_command)

    def __get_storage_dir(self) -> str:
        return "\"" + self.project.get_storage_dir() + "\""

    def __get_working_dir(self) -> str:
        return "\"" + self.project.get_working_dir() + "\""
