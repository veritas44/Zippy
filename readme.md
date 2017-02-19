#Zippy
##General
Zippy is a file sharing platform designed to transfer files from one computer to another without inputing any sensitive information such as usernames and passwords. 
##Process
When you drop your files into the dropzone on the homepage, they’re uploaded through asynchronous POST requests protected with a CSRF token and SSL. They’re then temporarily stored on a server in Frankfurt, waiting for you to confirm that you’re done uploading and ready to zip them up. Once you do that, a zip archive spawns on the server containing your files. The originals are deleted at that moment. If you upload files without zipping them, they’ll stay on the server for a day, unaccessible to the public, you won’t be able to recover them.
##Development
Zippy is on Github and I’m open to suggestions and pull requests. Don’t be shy if you have an idea or even better: the execution of your idea in a fork.