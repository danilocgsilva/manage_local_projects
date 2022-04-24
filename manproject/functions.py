from manproject.Project import Project
from manproject.Sync import Sync
import os
# import boto3

def show_all_data_from_project(project_name: str):
    project = Project(project_name)
    print("The working directory is {}".format(project.get_working_dir()))
    print("The storage directory is {}".format(project.get_storage_dir()))
    print("The type of storage is {}".format(project.get_source_type()))
    if project.get_deploy_place() == "":
        print("No deploy place setted.")
    else:
        print("The deploy destiny is {}".format(project.get_deploy_place()))

def to_working_dir(project_name: str):
    project = Project(project_name)
    if project.get_source_type() == 'local':
        Sync(Project(project_name)).to_working()
    else:
        command = "git clone {} {}".format(project.get_storage_dir(), project.get_working_dir())
        os.system(command)

def deploy(project_name: str):
    
    project = Project(project_name)
    deploy_type = project.get_deploy_type()
    if deploy_type == "s3":
        working_dir = project.get_working_dir()
        deploy_place = "s3://" + project.get_deploy_place()
        command = "aws s3 sync \"{}\" \"{}\" --profile $AWS_PROFILE".format(working_dir, deploy_place)
        os.system(command)
    else:
        print("The deploy is no not yet implemented for this type of deploy.")

def change(project_name: str):
    project = Project(project_name)
    project.set_deploy_place(input("Please, set the deploy place: "))
    project.set_deploy_type(input("Please, set the deploy type: "))
    project.save()

    

    