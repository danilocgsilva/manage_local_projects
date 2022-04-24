from manproject.ProjectConfig import ProjectConfig
import json

class Project:

    def __init__(self, project_name: str):
        config_file_path = ProjectConfig().get_config_file_path()
        config_data = json.load(
            open(config_file_path)
        )
        self.project_data = config_data[project_name]

    def get_working_dir(self) -> str:
        return self.project_data["working_dir"]

    def get_storage_dir(self) -> str:
        return self.project_data["source_address"]

    def get_source_type(self) -> str:
        return self.project_data["source_type"]

    def get_deploy_place(self) -> str:
        return self.project_data["deploy_place"]
