# Theme development and deployment

This document outlines the commands and processes for developing, linting, and deploying the theme.

## Local Development

The project includes `npm` scripts to automate the build and development process.

### Primary Commands

- **`npm run start`**: For **development**. Builds all assets once, then starts a watcher to automatically rebuild CSS files in real-time as you make changes. This is the main command to use during development.
- **`npm run build`**: For **production**. Performs a full, clean build of all theme assets (`css` and `svg`) into the `dist/` directory, ready for deployment.

> [!IMPORTANT]
> **Asset reloading:** While `npm start` automatically rebuilds assets, whether these changes appear immediately on your local site depends on your environment. Tools like [Local](https://localwp.com/) with its "[Instant Reload](https://localwp.com/help-docs/local-features/instant-reload/)" feature provide immediate **CSS updates**.

> [!NOTE]
> When running `npm start`, SVG files are built once at the beginning. Unlike CSS, they are not watched for changes, so the script should be restarted if new SVGs are added.

> [!TIP]
> You **don't need to manually run `npm run build`**. See [Deployment](#deployment) for more info.

### Code Quality

Code quality checks for formatting and linting can be run manually at any time.

- **`npm run format`**: Formats all code.
- **`npm run lint`**: Lints all CSS (and other) files.

It's also recommended to install the extensions for these tools in your code editor (e.g., VS Code extensions).

## Deployment

The theme is deployed automatically using a **CI/CD pipeline** via GitHub Actions, as defined in `.github/workflows/deploy.yml`.

### How it Works

1. **Trigger**: The pipeline is triggered on any push to the branch defined in `deploy.yml` (e.g., `main` or `dev`).
2. **Target**: The deployment targets the **staging server**.
3. **Build Step**: The pipeline first runs `npm run build` to generate the production-ready assets in the `dist/` folder.
4. **Deployment**: The pipeline then uses `rsync` to transfer files to the server. It respects the rules in the `.rsyncignore` file to exclude all unnecessary development files (`node_modules`, `src`, config files, etc.), ensuring only the minimal, optimized set of production files is deployed.
