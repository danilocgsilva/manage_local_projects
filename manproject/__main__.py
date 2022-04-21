import os

def main():
    os_command = "rsync -rv --delete $PROJECT_WORKING $PROJECT_STORAGE"
    os.system(os_command)

