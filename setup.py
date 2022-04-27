from setuptools import setup

VERSION = "0.1.1"

def readme():
    with open("README.md") as f:
        return f.read()

setup(
    name="manproject",
    version=VERSION,
    description="Manages local machine projects",
    long_description_content_type="text/markdown",
    long_description=readme(),
    keywords="management dev",
    url="",
    author="Danilo Silva",
    author_email="contact@danilocgsilva.me",
    packages=["manproject"],
    entry_points={"console_scripts": ["mpro=manproject.__main__:main"],},
    include_package_data=True
)

