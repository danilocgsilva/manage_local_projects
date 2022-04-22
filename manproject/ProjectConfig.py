import os
import json
from pathlib import Path

class ProjectConfig:

    def __init__(self) -> None:
        self.project_name = None
        self.working_dir = None
        self.source_type = None
        self.source_address = None
        self.file_location_config = os.path.join(str(Path.home()), ".mpro")

    def add(self):
        self.__ask_project_name()
        self.__ask_working_dir()
        self.__ask_source_type()
        self.__ask_source_address()
        self.write_to_file()

    def remove(self, project):
        with open(self.file_location_config) as conf_file:
            data_configurations = json.load(conf_file)

        data_configurations.pop(project, None)
        
        with open(self.file_location_config, 'w') as outfile:
            json.dump(data_configurations, outfile, indent = 4)

    def list(self):
        with open(self.file_location_config) as conf_file:
            data_configurations = json.load(conf_file)
        for key in data_configurations:
            print(key)

    def write_to_file(self):
        with open(self.file_location_config) as conf_file:
            data_configurations = json.load(conf_file)

        data_configurations[self.project_name] = {
            "working_dir": self.working_dir,
            "source_type": self.source_type,
            "source_address": self.source_address
        }
        
        with open(self.file_location_config, 'w') as outfile:
            json.dump(data_configurations, outfile, indent = 4)

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

    