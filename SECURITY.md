# Security

This repository is lightly maintained. Security fixes are prioritized for active use, but where a
full dependency replacement would be invasive and untested, low-risk pipeline patches (such as
`npm overrides`) are preferred to keep the build stable.

---

## Known advisories

### minimatch ReDoS — CVE-2026-27903 / CVE-2026-27904 / CVE-2026-26996

| Field | Detail |
|---|---|
| **Affected package** | `minimatch < 3.1.3` (npm) |
| **Introduced via** | `postcss-url@10.1.3` → `minimatch@3.0.8` |
| **Patched version** | `minimatch >= 3.1.3` (override resolves to `10.2.4` as of this writing) |
| **Dependabot alert** | [#27](https://github.com/germanfrelo/wp-theme-template/security/dependabot/27) |
| **Fix PR** | [#200](https://github.com/germanfrelo/wp-theme-template/pull/200) |

**Summary:** `matchOne()` in minimatch performs unbounded recursive backtracking when a glob
pattern contains multiple non-adjacent `**` (GLOBSTAR) segments and the input path does not
match. The time complexity is O(C(n, k)) — binomial — where n is the number of path segments
and k is the number of globstars. With k=11 and n=30, a single call stalls the Node.js event
loop for ~5 seconds. No memoization or call budget existed to bound this behavior.

**Why `postcss-url` cannot be updated upstream:** The package has not had a release since
2021-03-19 and appears unmaintained (see
[postcss/postcss-url#184](https://github.com/postcss/postcss-url/issues/184)). A community PR
to bump minimatch ([postcss/postcss-url#185](https://github.com/postcss/postcss-url/pull/185))
has received no response from the author.

**Workaround applied:** An [`overrides`](https://docs.npmjs.com/cli/v10/configuring-npm/package-json#overrides)
entry in `package.json` forces all transitive dependents of `minimatch` to resolve to
`>= 3.1.3`, which contains the fix. This is an intentional workaround, not an oversight:

```json
"overrides": {
  "minimatch": ">=3.1.3"
}
```

A full replacement of `postcss-url` with a custom inline PostCSS plugin (PR #198) was
considered but closed in favor of this lower-risk patch, given the unmaintained status of
the package and the build-safety risk of an untested plugin replacement.
