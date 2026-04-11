# Cycle Chesterfield Plugin

## What this plugin does

This WordPress plugin provides specific snippets, customisations, and custom blocks for the Cycle Chesterfield site.

## Included blocks

### Ride Grade

The `Ride Grade` block lets editors choose a ride grade in the block settings and outputs the matching description automatically.

When inserted, the block renders a heading such as `Grade 1 Ride` followed by the appropriate ride description.

This block is limited to one instance per post, which helps keep an event's ride difficulty clear and unambiguous.

### Ride Grades

The `Ride Grades` block displays all available ride grades together with their descriptions.

Use this on explainer pages where you want visitors to compare the different ride levels side by side.

## Try It In Playground

You can try the plugin in WordPress Playground here:

[Try Cycle Chesterfield in Playground](https://playground.wordpress.net/?blueprint-url=https%3A%2F%2Fraw.githubusercontent.com%2Fdsas%2Fcycle-chesterfield-plugin%2Fmain%2Fblueprint.json)

## Releases

GitHub Actions creates a release automatically when a tag matching `v*` is pushed to the repository.

Each release includes a WordPress-installable asset named `cycle-chesterfield.zip`.

Typical release flow:

1. Update the plugin version as needed.
2. Commit and push your changes.
3. Create and push a tag such as `v1.0.0`.
