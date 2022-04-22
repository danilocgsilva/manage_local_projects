import os

class AddProject:

    def __init__(self) -> None:
        self.project_name = None
        self.working_dir = None
        self.source_type = None
        self.source_address = None

    def add(self):
        self.__ask_project_name()
        self.__ask_working_dir()
        self.__ask_source_type()
        self.__ask_source_address()
        print(
            "Finished! The project name is {}. The working directory is {}. The source type is {}. The source address is {}.".format\
            (self.project_name, self.working_dir, self.source_type, self.source_address)
        )

    def __ask_project_name(self):
        project_name_answer = input("Type the project's name: ")
        self.project_name = project_name_answer

    def __ask_working_dir(self):
        while self.working_dir is None:
            working_dir_answer = input("Type the working directory: ")
            if os.path.exists(working_dir_answer):
                self.working_dir = working_dir_answer
            else:
                print("The provided answer must match an existing local path.")

    def __ask_source_type(self):
        while self.source_type is None:
            source_type_answer = input("Is the source based on github or a local directory? Type 'github' or 'local': ")
            if source_type_answer not in ['github', 'local']:
                print("The source type must be 'github' or 'local'.")
            else:
                self.source_type = source_type_answer

    def __ask_source_address(self):
        while self.source_address is None:
            source_address_answer = input("Type the source address: ")
            self.source_address = source_address_answer
