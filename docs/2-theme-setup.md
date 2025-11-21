# Theme setup guide

Guide for setting up the theme for local development.

## Step 1: Theme repository

From your terminal, navigate to the `/wp-content/themes/` directory of your local site and [Cloning a repository - GitHub Docs](https://docs.github.com/en/repositories/creating-and-managing-repositories/cloning-a-repository#cloning-a-repository) this repository.

> [!IMPORTANT]
> If your local site has already been imported with the project theme, you need to delete it and replae it with the theme that has been cloned from the repository. **Make sure that the current theme can be removed entirely beforehand**.

## Step 2: Install dependencies

Navigate into the theme directory and install the necessary Node and PHP dependencies:

### Node dependencies (npm)

```sh
npm install
```

### PHP dependencies (Composer)

```sh
composer install
```

### Verify installations (quick sanity check)

```sh
node -v
npm -v
php -v
composer --version
vendor/bin/phpcs --version
vendor/bin/phpcs -i
```

## Step 3: Replace theme template placeholders

**Assuming the theme repository is created using a theme template/boilerplate**, use your code editor's global "search and replace" funcionality to replace all instances of the following placeholders that are thoughout the codebase of the theme template with the project's information. **Exclude Markdown files (`*.md`) to avoid replacing these placeholders in this file.**

- `themeauthor`
- `themedescription`
- `themename`
- `themerepourl`
- `themeslug`
- `themeurl`
