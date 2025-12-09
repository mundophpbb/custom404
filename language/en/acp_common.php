<?php
/**
 * ACP Language File for Custom 404 Page Extension (English)
 *
 * @package mundophpbb\custom404\language\en
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */
if (!defined('IN_PHPBB')) {
    exit;
}
if (empty($lang) || !is_array($lang)) {
    $lang = [];
}
$lang = array_merge($lang, [
    // ACP Module Interface
    'ACP_CUSTOM404_CATEGORY' => 'Custom 404 Error',
    'ACP_CUSTOM404_SETTINGS' => 'Settings',
    'ACP_CUSTOM404_TITLE' => 'Custom 404 Page',
    'ACP_CUSTOM404_TITLE_LABEL' => '404 Page Title',
    'ACP_CUSTOM404_MESSAGE_LABEL' => '404 Page Message',
    'ACP_CUSTOM404_BBCODE_INFO' => 'Use BBCode like [b]bold[/b], [i]italic[/i], [url]link[/url] or [img]image[/img] to format the message.',
    'ACP_CUSTOM404_SAVED' => 'Settings saved successfully!',
    'ACP_CUSTOM404_RESET_DEFAULT' => 'Reset to Default',
    'ACP_CUSTOM404_RESET_CONFIRM' => 'Are you sure you want to reset the title, message, and image alt text to the default values?',
    'ACP_CUSTOM404_RESET_SUCCESS' => 'Settings reset to default values successfully!',
    // Image Settings
    'ACP_CUSTOM404_SHOW_IMAGE' => 'Display Image on 404 Page',
    'ACP_CUSTOM404_SHOW_IMAGE_ON' => 'Enabled',
    'ACP_CUSTOM404_SHOW_IMAGE_OFF' => 'Disabled',
    'ACP_CUSTOM404_IMAGE_ALT_LABEL' => 'Image Alt Text',
    'ACP_CUSTOM404_IMAGE_PATH_LABEL' => '404 Page Image',
    'ACP_CUSTOM404_IMAGE_PATH_EXPLAIN' => 'Select an image from the extension\'s uploads directory.',
    'ACP_CUSTOM404_IMAGE_PREVIEW' => 'Image Preview',
    'ACP_CUSTOM404_IMAGE_UPLOAD' => 'Upload New Image',
    'ACP_CUSTOM404_UPLOAD_INFO' => 'Allowed formats: %s. Maximum size: %d MB.',
    'ACP_CUSTOM404_DEFAULT_IMAGE' => 'Default Image (404_error.png)',
    'ACP_CUSTOM404_CHOOSE_FILE' => 'Choose File',
    'ACP_CUSTOM404_NO_FILE_CHOSEN' => 'No File Chosen',
    'ACP_CUSTOM404_IMAGE_UPLOADED' => 'Image uploaded successfully!',
    'ACP_CUSTOM404_INVALID_FILE_TYPE' => 'Invalid file type. Only %s are allowed.',
    'ACP_CUSTOM404_FILE_TOO_LARGE' => 'The file exceeds the maximum allowed size of %d MB.',
    'ACP_CUSTOM404_UPLOAD_FAILED' => 'Failed to upload the image. Please try again.',
    'ACP_CUSTOM404_DELETE_IMAGE' => 'Delete Image',
    'ACP_CUSTOM404_DELETE_IMAGE_EXPLAIN' => 'Select an image to delete from the extension\'s uploads directory.',
    'ACP_CUSTOM404_DELETE' => 'Delete',
    'ACP_CUSTOM404_DELETE_CONFIRM' => 'Are you sure you want to delete this image?',
    'ACP_CUSTOM404_SELECT_IMAGE' => 'Select Image',
    'ACP_CUSTOM404_IMAGE_DELETED' => 'Image deleted successfully!',
    'ACP_CUSTOM404_IMAGE_NOT_FOUND' => 'Image not found.',
    'ACP_CUSTOM404_INVALID_IMAGE' => 'Invalid image selected.',
    'ACP_CUSTOM404_PERMISSION_DENIED' => 'Permission denied to delete the image. Check file permissions.',
    'ACP_CUSTOM404_LOG_DIR_FAILED' => 'Failed to create logs directory. Check server permissions.',
    'ACP_CUSTOM404_UPLOAD_DIR_FAILED' => 'Failed to create uploads directory. Check server permissions.',
    'ACP_CUSTOM404_DELETE_FAILED' => 'Failed to delete the image: %s',
    'ACP_CUSTOM404_NO_IMAGE_SELECTED' => 'No image selected for deletion.',
    'ACP_CUSTOM404_OK' => 'OK',
    // Theme and Debug Mode
    'ACP_CUSTOM404_THEME_LABEL' => '404 Page Theme',
    'ACP_CUSTOM404_THEME_LIGHT' => 'Light',
    'ACP_CUSTOM404_THEME_DARK' => 'Dark',
    'ACP_CUSTOM404_DEBUG_MODE' => 'Debug Mode',
    'ACP_CUSTOM404_DEBUG_EXPLAIN' => 'Enables debug mode to display additional log information, facilitating the diagnosis of 404 errors and configuration issues. Use only for development or troubleshooting purposes.',
    'ACP_CUSTOM404_DEBUG_MODE_ON' => 'Disable Debug Mode',
    'ACP_CUSTOM404_DEBUG_MODE_OFF' => 'Enable Debug Mode',
    // 404 Error Logging
    'ACP_CUSTOM404_LOGS' => '404 Error Logs',
    'ACP_CUSTOM404_URL' => 'Requested URL',
    'ACP_CUSTOM404_IP_ADDRESS' => 'Client IP',
    'ACP_CUSTOM404_REQUEST_TIME' => 'Request Date/Time',
    'ACP_CUSTOM404_REFERRER' => 'Referrer',
    'ACP_CUSTOM404_USER_AGENT' => 'User Agent',
    'ACP_CUSTOM404_NO_LOGS' => 'No 404 error logs found.',
    'ACP_CUSTOM404_EXPORT_LOGS' => 'Export Logs as CSV',
    'ACP_CUSTOM404_LOG_LIMIT' => 'Number of Logs to Display',
    'ACP_CUSTOM404_DELETE_LOGS' => 'Delete All Logs',
    'ACP_CUSTOM404_DELETE_LOGS_CONFIRM' => 'Are you sure you want to delete all 404 error logs older than 30 days?',
    'ACP_CUSTOM404_LOGS_DELETED' => '404 error logs deleted successfully! (%d logs removed)',
    'ACP_CUSTOM404_LOG_SEARCH' => 'Search Logs',
    'ACP_CUSTOM404_LOG_SEARCH_PLACEHOLDER' => 'Enter a URL, IP, referrer or user agent',
    'ACP_CUSTOM404_TOTAL_LOGS' => 'Total Logs',
    'ACP_CUSTOM404_CLEAR_SEARCH' => 'Clear Search',
    'ACP_CUSTOM404_NO_LOGS_DELETED' => 'No logs were deleted, as there are no logs older than 30 days.',
    'ACP_CUSTOM404_SEARCH_CLEARED' => 'Log search cleared successfully.',
    'ACP_CUSTOM404_PAGINATION_ERROR' => 'Error generating log pagination. Please try again or contact support.',
    // BBCode Help
    'BBCODE_B_HELP' => 'Bold: [b]text[/b]',
    'BBCODE_I_HELP' => 'Italic: [i]text[/i]',
    'BBCODE_U_HELP' => 'Underline: [u]text[/u]',
    'BBCODE_URL_HELP' => 'Link: [url=http://example.com]text[/url] or [url]http://example.com[/url]',
    'BBCODE_IMG_HELP' => 'Image: [img]http://example.com/image.jpg[/img]',
    'BBCODE_QUOTE_HELP' => 'Quote: [quote]text[/quote]',
    'BBCODE_INSTRUCTIONS' => 'Use BBCode to format the message, like [b]bold[/b], [url]link[/url] or [img]image[/img].',
    // 404 Page Default Values
    'CUSTOM404_DEFAULT_TITLE' => '404 - Page Not Found',
    'CUSTOM404_DEFAULT_MESSAGE' => 'Oops, the page you\'re looking for doesn\'t exist!',
    'CUSTOM404_DEFAULT_IMAGE_ALT' => '404 Error Image',
    // Form Validation
    'FORM_INVALID' => 'Invalid form. Please try again.',
    'FORM_TOKEN_MISSING' => 'Error: Form token not found.',
    'ACP_CUSTOM404_TITLE_REQUIRED' => 'The title cannot be empty.',
    'ACP_CUSTOM404_MESSAGE_REQUIRED' => 'The message cannot be empty.',
    'ACP_CUSTOM404_TITLE_TOO_SHORT' => 'The title must be at least 3 characters long.',
    'ACP_CUSTOM404_MESSAGE_TOO_SHORT' => 'The message must be at least 3 characters long.',
    // General Buttons and Interface
    'ACP_CUSTOM404_UPLOAD_IMAGE' => 'Upload Image',
    'ACP_CUSTOM404_SAVE_CHANGES' => 'Save Changes',
    'L_BACK_TO_INDEX' => 'Back to Index',
    'L_CANCEL' => 'Cancel',
]);