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
        return self.project_data["source_type"]

    def get_deploy_place(self) -> str:
        return self.project_data["deploy_place"] if "deploy_place" in self.project_data else ""

    def set_deploy_place(self, deploy_place):
        self.project_data["deploy_place"] = deploy_place
        return self

    def set_deploy_type(self, deploy_type: str):
        self.project_data["deploy_type"] = deploy_type
        return self

    def get_deploy_type(self) -> str:
        return self.project_data["deploy_type"]

    def save(self):
        config_data = json.load(
            open(self.config_file_path)
        )
        config_data[self.project_name] = self.project_data

        with open(self.config_file_path, 'w') as outfile:
            json.dump(config_data, outfile, indent = 4, ensure_ascii=False)

        return self