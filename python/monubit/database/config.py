# Import standard libraries
import yaml

# Get parameters
parameters = yaml.load(open("../app/config/parameters.yml", 'r')).get('parameters')
