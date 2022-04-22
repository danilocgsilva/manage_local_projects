import os

class Env:

    def __init__(self):
        self.working_dir = os.environ.get('PROJECT_WORKING')
        self.storage_dir = os.environ.get('PROJECT_STORAGE')

    def get_working_dir() -> str:
        return self.working_dir

    def get_storage_dir() -> str:
        return self.storage_dir
