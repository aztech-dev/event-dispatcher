# Contribution guidelines

All contributions to the library are welcome, be it issues or pull requests, as long as they follow simple guidelines.

## Issues

When submitting an issue, please make sure it does not already exist. If it does exist, feel free to comment the existing one to complement the existing issue.

If you need to create a new issue, please try to document the context of the issue and steps to reproduce the issue. It's always nice if you include a 3vl4.org link reproducing your issue.

## Pull requests

If you want to submit a pull request, please document the submitted changes and their goal. 

Also, contributors will be asked to fix their pull requests if they do not pass all tests.

### Testing

To ensure consistent testing between dev machines and Travis, all the build process is included as a Makefile, and you just need to run the following command to ensure your changes validate :

```bash
$ cd /path/to/project && make test
```
