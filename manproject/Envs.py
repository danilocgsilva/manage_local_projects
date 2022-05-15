import json
from pathlib import Path
import os

class Envs:
    
    def load_envs(self) -> dict:
        home = str(Path.home())

        return json.load(
            open(os.path.join(home, ".mpro_envs"))
        )