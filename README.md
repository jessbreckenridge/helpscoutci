# HelpScout CI/CD Demo.


## Architecture Decisions

Gravity.

I framed this as an expirement in gravity. 

I frequently ask new devops personnel "Should we glue plates to the table to prevent them from flying off?". The answer has always been, "No". We do not of course glue plates to tables, gravity keeps them from floating away. It's the law :-)

I have setup many full fledged configuration managed environments with CI/CD systems enabled. I also know that they take time to work out the build out the entire stack and integrate. For this excercise, I challenged myself to keep the implimentation lightweight, and to use the "gravity" of AWS resources to do the undifferentiated heavy lifting. This was primarily due to the limited scope of time that I had, and the desire to have a bit of fun with the project.


## Investigation of available resoures.

The first thing I did was investigate what AWS services were available to utilize. 

- Codepipeline: Monitors github repositories, and configures pipelines for build, and deploy.
- CodeDeploy: Deploys applications to a fleet of instances. It however, does not support immutable instances.
- Elastic Beanstalk. Useful for deploying new immutable intances in a red/back manner.

Amazon did not have a suitable CI service. I evaluated the following services:

- Codeship: Previous experience ruled this out, due to lack of capabilities.
- Circle CI: See above.
- Solano CI: Reccomended, but not used. Decided to give it a try.

Solano CI seemed to have solid documentation, capabilities for multiple languages, supported upto 4 workers on it's 14 day trial. Due to this I chose to test it out.

I scaffolded the existing PHP demo for elastic beanstalk. I used a variable in the code to display the message "Automation for the People". This was due to difficulting finding a unit test frameworks for HTML.

The load balancer was configured to check for a 200 status before switching instances into the load balancer.

## Workflow

The workflow for the pipeline is:

Github commit (staging branch) -> Solano CI -> Elastic Beanstalk

## Instructions:

Simply commit code into the repository on the staging branch. It will provision new instances, test them, and deploy them into the environment. Upon passing health checks, put these new instances into the load balancer, and remove the old ones.


# Github repo: https://github.com/jessicabreck/helpscoutci.git


## Lessons learned:

- While suitable for the example of tis test, I would not deploy this to production. Glaring issues that I did not have the time to resolve:
	- Lack of bespoke, hardened instances.
	- Lack of configuration management and orchestration, beyond cloudformation templates.
	- No log aggregation (splunk, ELKstack, etc.)
	- No proper health check in the code.
	- No canary deploys (LinkerD, or ELB w/ weighted route 53 A records). Non functional, or non-optimal hosts could easily make it to production.
	



