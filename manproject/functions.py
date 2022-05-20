from manproject.Project import Project
from manproject.ProjectChanger import ProjectChanger
from manproject.Sync import Sync
from manproject.Envs import Envs
import os

def show_all_data_from_project(project_name: str):
    project = Project(project_name)
    print("The working directory is {}".format(project.get_working_dir()))
    print("The storage directory is {}".format(project.get_storage_dir()))
    print("The type of storage is {}".format(project.get_source_type()))

    if project.get_deploy_place() == "":
        print("No deploy place setted.")
    else:
        print("The deploy destiny is {}".format(project.get_deploy_place()))

    if project.get_production_directory() == "":
        print("No production directory setted.")
    else:
        print("The production directory is {}.".format(project.get_production_directory()))


def to_working_dir(project_name: str):
    '''
    Copy files from storage directory to working directory.
    '''
    project = Project(project_name)
    if project.get_source_type() == 'local':
        Sync(Project(project_name)).to_working()
    else:
        if len(os.listdir(project.get_working_dir())) == 0:
            command = "git clone {} {}".format(project.get_storage_dir(), project.get_working_dir())
        else:
            command = "git -C {} pull".format(project.get_working_dir() + "/")
        os.system(command)

def deploy(project_name: str):
    '''
    Send files from working directory to where the files will be consumed
    by the server.
    '''

    project = Project(project_name)
    environments_data = project.get_environments()
    environment = input("Which where the environment to deploy? ")
    if environment in environments_data:
        environmen_choosed = environments_data[environment]
        if environmen_choosed["type"] == "ssh":
            command = "scp -i {} -rv {} {}".format(
                environmen_choosed["key"],
                os.path.join(project.get_working_dir(), project.get_production_directory(), "*"),
                environmen_choosed["fulladdress"]
            )
            os.system(command)
        elif environmen_choosed["type"] == "s3":

            if project.get_production_directory():
                source = os.path.join(project.get_working_dir(), project.get_production_directory())
            else:
                source = project.get_working_dir()

            command = "aws s3 cp {} {} --recursive".format(
                source, 
                "s3://" + environmen_choosed["fulladdress"]
            )
            os.system(command)
        else:
            print("Sorry! Another deployt type still is not implemented.")
    else:
        print("The environment does not exists. Skiping...")


def change(project_name: str):
    '''
    Alter data from a given project.
    '''
    project = Project(project_name)
    projectChanger = ProjectChanger(project)
    projectChanger.ask_deploy_place()
    projectChanger.ask_deploy_type()
    projectChanger.ask_production_directory()
    projectChanger.ask_storage_type()

    project.persists()
