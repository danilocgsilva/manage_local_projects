from manproject.Project import Project
import os

class ProjectChanger:

    def __init__(self, project: Project):
        self.project = project

    def ask_deploy_place(self):
        
        if self.project.get_deploy_place() == "":
            text = "Please, set the deploy place: "
        else:
            text = "Please, set the deploy place ({}): ".format(self.project.get_deploy_place())

        user_input = input(text)
        if user_input != "":
            self.project.set_deploy_place(user_input)
    
    def ask_deploy_type(self):

        if self.project.get_deploy_type() == "":
            text = "Please, set the deploy type: "
        else:
            text = "Please, set the deploy type ({}): ".format(self.project.get_deploy_type())

        user_input = input(text)
        if user_input != "":
            self.project.set_deploy_type(user_input)

    def ask_production_directory(self):
        '''
        A generic function that return the user input only if the resulting path
        is an existing one.
        '''
        asking_text = "Please, set the production directory (relative to the working directory): "
        valid_value = False
        while not valid_value:
            user_input = input(asking_text)
            assembled_full_path = os.path.join(self.project.get_working_dir(),  user_input)
            if not os.path.exists(assembled_full_path):
                print("The provided path ({}) does not exists.".format(assembled_full_path))
            else:
                valid_value = True

        self.project.set_production_directory(user_input)

    def ask_storage_type(self):
        asking_text = "Please, set the source type: "
        user_input = input(asking_text)
        self.project.set_source_type(user_input)
