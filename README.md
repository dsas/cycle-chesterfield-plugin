# Cycle Chesterfield Plugin

## What this plugin does

This WordPress plugin provides site-specific custom blocks and The Events Calendar display customisations for the Cycle Chesterfield website.

Current features:

1. Registers two editor blocks for ride grade content.
2. Shares centrally managed ride grade labels/descriptions with both blocks.
3. Hides event end times in The Events Calendar output so time ranges like `6:30 pm - 7:30 pm` display as `6:30 pm`.

## Included blocks

### Ride Grade

The `Ride Grade` block lets editors choose a ride grade in the block settings and outputs the matching description automatically.

When inserted, the block renders a heading such as `Grade 1 Ride` followed by the appropriate ride description.

This block is limited to one instance per post, which helps keep an event's ride difficulty clear and unambiguous.

### Ride Grades

The `Ride Grades` block displays all available ride grades together with their descriptions.

Use this on explainer pages where you want visitors to compare the different ride levels side by side.

## Event time display customisation

The plugin includes a dedicated customisation file:

- `includes/hide-event-end-times.php`

This customisation keeps event end times in stored event data, but hides them in frontend display contexts used on the site, including:

1. The Events Calendar single-event time display.
2. The Events Calendar schedule detail formatting.
3. The Events Calendar event date-time block output.
4. The Events Calendar widget events list date output.

This ensures users see a single start time (for example, `6:30 pm`) instead of a start/end range.

## Dependencies

For event-time customisations, this plugin expects The Events Calendar plugin to be active.

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
