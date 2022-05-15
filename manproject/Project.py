from itertools import product
from manproject.ProjectConfig import ProjectConfig
import json

class Project:

    def __init__(self, project_name: str):
        self.project_name = project_name
        self.config_file_path = ProjectConfig().get_config_file_path()
        config_data = json.load(
            open(self.config_file_path)
        )
        self.project_data = config_data[self.project_name]

    def get_working_dir(self) -> str:
        return self.project_data["working_dir"]

    def get_storage_dir(self) -> str:
        return self.project_data["source_address"]

    def get_source_type(self) -> str:
        '''
        The source can be local, git_remote or S3.
        '''
        return self.project_data["source_type"]

    def set_source_type(self, storage_type: str):
        self.project_data['source_type'] = storage_type
        return self

    def get_deploy_place(self) -> str:
        '''
        Path where deploy will occur. For example, it can be a AWS S3 bucket
        if the deploy type is S3.
        '''
        return self.project_data["deploy_place"] if "deploy_place" in self.project_data else ""

    def set_deploy_place(self, deploy_place):
        '''
        The deploy place is where the files will be sent to be consumed by
        production server.
        '''
        self.project_data["deploy_place"] = deploy_place
        return self

    def set_deploy_type(self, deploy_type: str):
        '''
        The 'S3' as deploy type if you project run in a S3 bucket.
        '''
        self.project_data["deploy_type"] = deploy_type
        return self

    def set_production_directory(self, production_directory):
        '''
        Set the directory that must be sent to the server.
        '''
        self.project_data["production_directory"] = production_directory
        return self

    def get_production_directory(self) -> str:
        '''
        Usually, in the development environment environment, you have files that
        usually must not go to the production server. For example, for web projects,
        you may have a special folder called 'build' where the files are consumed
        by the server, and all the remaining are just development assets. So
        setting a production file path is needed to allow the deploy script
        knows which files must be sent to the server.
        '''
        return self.project_data["production_directory"] if "production_directory" in self.project_data else ""

    def get_deploy_type(self) -> str:
        return self.project_data["deploy_type"] if "deploy_type" in self.project_data else ""

    def persists(self):
        '''
        Changing the class data may still not change the data in server. You must
        use this method to commit the data.
        '''
        config_data = json.load(
            open(self.config_file_path)
        )
        config_data[self.project_name] = self.project_data

        with open(self.config_file_path, 'w') as outfile:
            json.dump(config_data, outfile, indent = 4, ensure_ascii=False)

        return self