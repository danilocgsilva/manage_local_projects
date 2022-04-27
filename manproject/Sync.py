from manproject.Project import Project
import os

class Sync:

    def __init__(self, project: Project):
        self.project = project

    def to_storage(self):
        if self.project.get_source_type() == "local":
            os_command = "rsync -rv " + self.__get_working_dir() + "/ " + self.__get_storage_dir() + "/"
            os.system(os_command)
        elif self.project.get_source_type() == "github":
            os_command = "git -C {} pull".format(self.project.get_working_dir())
            os.system(os_command)
        else:
            print("The source type {} still was not implemented.".format())
        
    def to_working(self):
        if self.project.get_source_type() == "local":
            os_command = "rsync -rv " + self.__get_storage_dir() + "/ " + self.__get_working_dir() + "/"
            os.system(os_command)
        elif self.project.get_source_type() == "github":
            print("The source type is from github. not implemented yet.")
        elif self.project.get_source_type() == "s3":
            print("The source type is from s3. not implemented yet.")
        else:
            print("The source type os not known.")

    def __get_storage_dir(self) -> str:
        return "\"" + self.project.get_storage_dir() + "\""

    def __get_working_dir(self) -> str:
        return "\"" + self.project.get_working_dir() + "\""
