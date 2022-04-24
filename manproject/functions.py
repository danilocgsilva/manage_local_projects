from manproject.Project import Project
from manproject.Sync import Sync
import os

def show_all_data_from_project(project_name: str):
    project = Project(project_name)
    print("The working directory is {}".format(project.get_working_dir()))
    print("The storage directory is {}".format(project.get_storage_dir()))
    print("The type of storage is {}".format(project.get_source_type()))

def to_working_dir(project_name: str):
    project = Project(project_name)
    if project.get_source_type() == 'local':
        Sync(Project(project_name)).to_working()
    else:
        command = "git clone {} {}".format(project.get_storage_dir(), project.get_working_dir())
        os.system(command)
