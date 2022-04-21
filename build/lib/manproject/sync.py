import os

def sync():
    project_working_dir = os.environ.get('PROJECT_WORKING')
    project_storage_dir = os.environ.get('PROJECT_STORAGE')

    if project_working_dir and project_storage_dir:
        os_command = "rsync -rv --delete $PROJECT_WORKING $PROJECT_STORAGE"
        os.system(os_command)
    else:
        print("No source and/or destiny for current project.")