# CSS Overrides (WordPress / editor fixes)

## Purpose

This folder contains small stylesheet files whose sole purpose is to
override WordPress block editor-generated CSS. These are implementation
fixes, not reusable utilities.

## Guidelines

- Keep the files focused and small — one override per file.
- Name files to indicate the target, for example: `has-global-padding.css`.

## Load / order

Overrides must be imported last in the build pipeline so they reliably win
over editor-generated styles. See the example import snippet in the
project documentation (`docs/3-theme-structure.md`).

## When to use

- Use this folder only for fixes that address WordPress or plugin-generated
  CSS you cannot control via `theme.json` or a better upstream solution.
- If a rule is a true reusable utility, keep it in `src/css/utilities/`.

## Maintenance

Track these files during WordPress upgrades — changes to the editor's
output may require updates or removal of overrides.
