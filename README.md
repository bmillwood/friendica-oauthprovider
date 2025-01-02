This addon was developed to support an application I wrote that wanted to make
API calls to Friendica on behalf of users, in order to allow people who were
friends on Friendica to find each other in the app.

Friendica, I found, did have OAuth for authorising API calls, but I couldn't
find existing uses of it, or documentation of how to use it. I read the code,
did some experiments, and wrote https://wiki.friendi.ca/docs/api-authentication
to document what I'd learned.

One necessary component was modifying the `application` table in the database,
which I found no native way to do, so I wrote this addon to allow admins to do
it manually.

I haven't finished my app yet, so I'm not aware of any live production
deployments of this addon. Use it at your own risk. Don't trust that someone
else has done the necessary thinking about security for you.
