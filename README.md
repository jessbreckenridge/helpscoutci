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
- Elastic Beanstalk. Useful for deploying new immutable intances in a red/black manner.

Amazon did not have a suitable CI service. I evaluated the following services:

- Codeship: Previous experience ruled this out, due to lack of capabilities.
- Circle CI: See above.
- Solano CI: Reccomended, but I had not previously used.

Solano CI seemed to have solid documentation, capabilities for multiple languages, and support for  4 workers during it's 14 day trial. Due to this I chose to test it out.


I them performed the following actions: 

- I created a simple test page with the words "Automation for the people"
- I instantiated a boilerplate Beanstalk configuration with a cloudformation template. I have saved this template in the cloudformation directory.
- ELB was configured to check for a 200 status before swapping the new instances into the load balancer.

## Workflow

The workflow for the pipeline is:

Github commit (staging branch) -> Solano CI -> Elastic Beanstalk

## Instructions:

Simply commit code into the repository on the staging branch. It will provision new instances, test them, and deploy them into the environment. Upon passing health checks, put these new instances into the load balancer, and remove the old ones. If you change the index.html text, it will fail upon deployment, and nothing will happen to the previous immutable instances.


Additional workflows from staging --> Production branch could be added, but are pointless with canary nodes + application monitoring.

# Github repo: https://github.com/jessicabreck/helpscoutci.git




## Lessons learned:

- While suitable for the example of tis test, I would not deploy this to production. Glaring issues that I did not have the time to resolve:
	- Lack of bespoke, hardened instances.
	- Lack of configuration management and orchestration, beyond cloudformation templates.
	- No log aggregation (splunk, ELKstack, etc.)
	- No proper health check in the code.
	- No canary deploys (LinkerD, or ELB w/ weighted route 53 A records). Non functional, or non-optimal hosts could easily make it to production.
	- Production test scalability, integration and holistic testing issues are to numerous to mention for a large scale microservices infrastructure.
    - Complete end to end code configuration needed: Terraform for AWS environment, ancillary script/boto for fine configuration. If you cannot hit a button and recreate it in an hour, it is not production ready.




