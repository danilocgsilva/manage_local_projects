from manproject.Project import Project

def show_all_data_from_project(project_name: str):
    project = Project(project_name)
    print("The working directory is {}".format(project.get_working_dir()))
    print("The storage directory is {}".format(project.get_storage_dir()))
    print("The type of storage is {}".format(project.get_source_type()))