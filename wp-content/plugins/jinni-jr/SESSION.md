# Jinni Jr — Session Notes

## Project

- WordPress plugin: `wp-content/plugins/jinni-jr/`
- Product requirements and phased plan: `ARCHITECTURE.md` in this directory.
- The plugin has a top-level WordPress dashboard menu positioned before Heliolisk, with System Prompt, Memory and Knowledge submenus.

## Work completed in this session

- Added a private `jinni_knowledge` custom post type. The Knowledge submenu opens the native WordPress list and classic editor, with title and description fields.
- Added an **Import DOCX** button above the editor. It uploads a `.docx` file through an administrator-only, nonce-protected AJAX endpoint and inserts extracted plain text into the editor. Save the entry to keep it. Maximum upload size is 5 MB; formatting is not preserved.
- Relevant files: `admin/class-knowledge.php`, `admin/assets/knowledge.js`, `admin/class-admin-page.php`, and `includes/class-plugin.php`.
- PHP and JavaScript syntax checks passed. The DOCX upload and editor have not been tested end-to-end in WordPress.

## Resume here

1. In WordPress admin, open **Jinni Jr → Knowledge**, create an entry, import a DOCX, verify its text appears, save it, and confirm it appears in the list and can be edited. Test invalid and oversized files as well.
2. Knowledge entries are not currently used as context for chatbot responses. Implement that integration if desired.
3. The frontend lawyer image references `public/assets/images/lawyer.gif`; the file was not supplied, so the widget may show a broken image until an asset is added.
4. The architecture is not fully implemented or verified: the WordPress AI Connector is a placeholder, and visitor identity collection, AI summaries, rate limiting and other acceptance criteria still need implementation and testing. Do not treat earlier claims that all phases are complete as verification.
5. The user previously requested PDF and document upload facilities. The current importer supports DOCX only; PDF and legacy DOC import remain outstanding.

## Other existing behavior

- Provider and system prompt settings are on the System Prompt page. Blank API-key submissions retain the saved key.
- The Memory page displays up to 100 recent visitors.
- No live WordPress or browser tests have been performed in this session.
