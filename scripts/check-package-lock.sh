#!/usr/bin/env bash

# Checks for package-lock.json changes, and if found, prompts to run 'npm ci'.

# Check if inside a git repository
if ! git rev-parse --is-inside-work-tree >/dev/null 2>&1; then
	exit 0 # Skip silently
fi

# Check if there are any commits yet
if ! git rev-parse --quiet HEAD >/dev/null 2>&1; then
	exit 0 # Skip silently
fi

# Check if package-lock.json exists
if [ ! -f "package-lock.json" ]; then
	exit 0 # Skip silently
fi

# Check for changes in package-lock.json
if ! git diff --quiet HEAD@{1} HEAD -- package-lock.json >/dev/null 2>&1; then
	if ! git rev-parse --verify HEAD@{1} >/dev/null 2>&1; then
		echo "📦ℹ️ Initial checkout. Run 'npm ci' to install dependencies."
	else
		echo "📦❗ package-lock.json has changed. Run 'npm ci' to update dependencies."
	fi
fi
