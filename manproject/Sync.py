import os

class Sync:

    def __init__(self):
        self.working_dir = os.environ.get('PROJECT_WORKING')
        self.storage_dir = os.environ.get('PROJECT_STORAGE')

    def to_storage(self):
        self.validate()
        os_command = "rsync -rv " + self.working_dir + " " + self.storage_dir
        os.system(os_command)
        
    def to_working(self):
        self.validate()
        os_command = "rsync -rv " + self.storage_dir + " " + self.working_dir
        os.system(os_command)

    def validate(self):
        if not self.working_dir or not self.storage_dir:
            raise Exception("No working dir ot storage dir defined.")
