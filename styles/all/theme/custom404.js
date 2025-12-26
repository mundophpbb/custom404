document.addEventListener('DOMContentLoaded', () => {
    // Obter traduções do elemento hidden
    const translationsElement = document.getElementById('custom404-translations');
    const lang = {
        titleRequired: translationsElement?.dataset.titleRequired || 'O título não pode estar vazio.',
        messageRequired: translationsElement?.dataset.messageRequired || 'A mensagem não pode estar vazia.',
        titleTooShort: translationsElement?.dataset.titleTooShort || 'O título deve ter pelo menos 3 caracteres.',
        messageTooShort: translationsElement?.dataset.messageTooShort || 'A mensagem deve ter pelo menos 3 caracteres.',
        noFileChosen: translationsElement?.dataset.noFileChosen || 'Nenhum Arquivo Escolhido',
        imagePreview: translationsElement?.dataset.imagePreview || 'Pré-visualização da Imagem',
        imageNotFound: translationsElement?.dataset.imageNotFound || 'Imagem não encontrada.',
        resetConfirm: translationsElement?.dataset.resetConfirm || 'Tem certeza de que deseja redefinir para os valores padrão?',
        defaultTitle: translationsElement?.dataset.defaultTitle || '404 - Página Não Encontrada',
        defaultMessage: translationsElement?.dataset.defaultMessage || 'Ops, a página que você está buscando não existe!',
        defaultImageAlt: translationsElement?.dataset.defaultImageAlt || 'Imagem de Erro 404',
        confirmButton: translationsElement?.dataset.confirmButton || 'Redefinir para o Padrão',
        cancelButton: translationsElement?.dataset.cancelButton || 'Cancelar',
        clearSearch: translationsElement?.dataset.clearSearch || 'Limpar Pesquisa',
        deleteConfirm: translationsElement?.dataset.deleteConfirm || 'Tem certeza de que deseja excluir a imagem selecionada?',
        noImageSelected: translationsElement?.dataset.noImageSelected || 'Nenhuma imagem selecionada para exclusão.',
        selectImage: translationsElement?.dataset.selectImage || 'Por favor, selecione uma imagem para excluir.',
        formTokenMissing: translationsElement?.dataset.formTokenMissing || 'Erro: Token do formulário não encontrado.',
        lAcpCustom404ThemeLight: translationsElement?.dataset.lAcpCustom404ThemeLight || 'Claro',
        lAcpCustom404ThemeDark: translationsElement?.dataset.lAcpCustom404ThemeDark || 'Escuro',
        lAcpCustom404DebugModeOn: translationsElement?.dataset.lAcpCustom404DebugModeOn || 'Desativar Modo de Depuração',
        lAcpCustom404DebugModeOff: translationsElement?.dataset.lAcpCustom404DebugModeOff || 'Ativar Modo de Depuração',
        lAcpCustom404ShowImageOn: translationsElement?.dataset.lAcpCustom404ShowImageOn || 'Ativado',
        lAcpCustom404ShowImageOff: translationsElement?.dataset.lAcpCustom404ShowImageOff || 'Desativado',
        logSearchPlaceholder: translationsElement?.dataset.logSearchPlaceholder || 'Digite para pesquisar logs...',
    };

    // Obter status do modo de depuração
    const debugMode = translationsElement?.dataset.debugMode === '1';

    // Função auxiliar para logging (apenas se debugMode for true)
    const logDebug = (...args) => {
        if (debugMode) {
            console.log('[DEBUG custom404.js]', ...args);
        }
    };
    const logError = (...args) => {
        if (debugMode) {
            console.error('[ERROR custom404.js]', ...args);
        }
    };

    logDebug('custom404.js loaded successfully at', new Date().toLocaleString());

    /**
     * Gerencia a inserção de BBCode em um textarea.
     * @param {string} startTag - A tag BBCode de abertura.
     * @param {string} endTag - A tag BBCode de fechamento.
     */
    const handleBBCodeInsertion = (startTag, endTag) => {
        logDebug('handleBBCodeInsertion called with tags:', startTag, endTag);

        const textarea = document.getElementById('custom404_message_key');
        if (!textarea) {
            logError('Textarea custom404_message_key not found');
            return;
        }

        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selectedText = textarea.value.substring(start, end);
        const textBefore = textarea.value.substring(0, start);
        const textAfter = textarea.value.substring(end);

        let newText;
        let cursorOffset;
        if (startTag === '[url]' && selectedText && selectedText.match(/^(https?:\/\/|www\.)/)) {
            newText = textBefore + `[url=${selectedText}]Link[/url]` + textAfter;
            cursorOffset = startTag.length + selectedText.length + 6; // Adjust for [url=...]
            logDebug('URL format applied: [url=' + selectedText + ']Link[/url]');
        } else {
            newText = textBefore + startTag + selectedText + endTag + textAfter;
            cursorOffset = startTag.length + selectedText.length;
            logDebug('Standard BBCode applied:', startTag + selectedText + endTag);
        }
        textarea.value = newText;

        const newCursorPos = start + cursorOffset;
        textarea.setSelectionRange(newCursorPos, newCursorPos);
        textarea.focus();

        logDebug('BBCode inserted successfully, new cursor position:', newCursorPos);
    };

    // Expor a função insertBBCode no escopo global para os eventos onclick (se necessário via HTML)
    window.insertBBCode = handleBBCodeInsertion;

    // Inicializa botões BBCode
    const bbcodeButtons = document.querySelectorAll('#format-buttons input.button2');
    if (bbcodeButtons.length === 0) {
        logError('No BBCode buttons found in #format-buttons');
    } else {
        logDebug('Found', bbcodeButtons.length, 'BBCode buttons');
    }

    /**
     * Gerencia a exibição do nome do arquivo selecionado.
     */
    const handleFileInputChange = () => {
        const fileInput = document.getElementById('custom404_image_upload');
        const fileNameSpan = document.getElementById('file-name');

        if (fileInput && fileNameSpan) {
            fileNameSpan.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : lang.noFileChosen;
            logDebug('File selected:', fileNameSpan.textContent);
        } else {
            logError('File input or file name span not found for file input change.');
        }
    };
    handleFileInputChange(); // Chama uma vez para inicializar o estado
    document.getElementById('custom404_image_upload')?.addEventListener('change', handleFileInputChange);

    /**
     * Gerencia a pré-visualização da imagem selecionada no dropdown.
     */
    const updateImagePreview = () => {
        const imagePathSelect = document.getElementById('custom404_image_path');
        const imagePreview = document.getElementById('image_preview');
        const previewMessage = document.getElementById('preview_message');

        if (imagePathSelect && imagePreview && previewMessage) {
            const selectedOption = imagePathSelect.options[imagePathSelect.selectedIndex];
            const imageSrc = selectedOption.dataset.absolutePath || selectedOption.value;
            const imageAlt = document.getElementById('custom404_image_alt_key')?.value || lang.defaultImageAlt;

            logDebug('Dropdown image selected:', imageSrc);

            if (imageSrc) {
                imagePreview.src = imageSrc;
                imagePreview.alt = imageAlt;
                imagePreview.style.display = 'block';
                previewMessage.style.display = 'none';

                imagePreview.onerror = () => {
                    imagePreview.src = '';
                    imagePreview.style.display = 'none';
                    previewMessage.textContent = lang.imageNotFound;
                    previewMessage.style.display = 'block';
                    logError('Failed to load image from:', imageSrc);
                };
            } else {
                imagePreview.src = '';
                imagePreview.style.display = 'none';
                previewMessage.textContent = lang.imagePreview;
                previewMessage.style.display = 'block';
                logDebug('No image path selected in dropdown, hiding preview.');
            }
        } else {
            logError('Image path select, image preview or preview message element not found for dropdown.');
        }
    };
    document.getElementById('custom404_image_path')?.addEventListener('change', updateImagePreview);
    updateImagePreview(); // Chama uma vez para garantir a pré-visualização inicial.

    /**
     * Gerencia a validação e submissão do formulário principal.
     */
    const setupMainFormValidation = () => {
        const mainForm = document.getElementById('custom404-main-form');
        const errorContainer = document.querySelector('.custom404-acp .error');

        if (!mainForm) {
            logError('Main form not found in ACP');
            return;
        }
        logDebug('Main form found:', mainForm);

        let formToken = mainForm.querySelector('input[name="form_token"]');
        if (!formToken) {
            logDebug('Form token not found in main form, adding dynamically');
            formToken = document.createElement('input');
            formToken.type = 'hidden';
            formToken.name = 'form_token';
            formToken.value = ''; // Should be set by backend
            mainForm.appendChild(formToken);
        }

        mainForm.addEventListener('submit', (e) => {
            const submitterName = e.submitter?.name || 'none';

            // Skip validation for specific buttons
            if (['search_logs', 'export_logs', 'clear_search'].includes(submitterName)) {
                return;
            }

            const titleInput = document.getElementById('custom404_title_key');
            const messageInput = document.getElementById('custom404_message_key');
            const fileInput = document.getElementById('custom404_image_upload');
            const errors = [];

            if (!formToken || !formToken.value) {
                logError('Form token missing or empty, reloading page');
                e.preventDefault();
                location.reload();
                return;
            }

            if (submitterName === 'submit') {
                if (!titleInput?.value.trim()) {
                    errors.push(lang.titleRequired);
                } else if (titleInput.value.trim().length < 3) {
                    errors.push(lang.titleTooShort);
                }

                if (!messageInput?.value.trim()) {
                    errors.push(lang.messageRequired);
                } else if (messageInput.value.trim().length < 3) {
                    errors.push(lang.messageTooShort);
                }
            }

            if (submitterName === 'upload' && fileInput && fileInput.files.length === 0) {
                errors.push(lang.noFileChosen);
                logDebug('No file selected for upload');
            }

            if (errors.length > 0) {
                e.preventDefault();
                if (errorContainer) {
                    errorContainer.textContent = errors.join(' ');
                    errorContainer.style.display = 'block';
                } else {
                    alert(errors.join('\n'));
                }
                logDebug('Form validation errors:', errors);
            } else if (errorContainer) {
                errorContainer.textContent = '';
                errorContainer.style.display = 'none';
            }
            logDebug('Main form submitted with submitter:', submitterName, 'form_token:', formToken.value || 'none');
        });

        // Specific validation for upload button
        document.querySelector('.file-upload input[name="upload"]')?.addEventListener('click', (e) => {
            logDebug('Upload button clicked');
            const fileInput = document.getElementById('custom404_image_upload');
            if (fileInput?.files.length === 0) {
                e.preventDefault();
                if (errorContainer) {
                    errorContainer.textContent = lang.noFileChosen;
                    errorContainer.style.display = 'block';
                } else {
                    alert(lang.noFileChosen);
                }
                logDebug('Upload attempted without selecting a file');
            }
        });
    };
    setupMainFormValidation();

    /**
     * Configura o popup de redefinição para os valores padrão.
     */
    const setupResetDefaultPopup = () => {
        const resetButton = document.getElementById('custom404-reset-default');
        const resetPopup = document.getElementById('custom404-reset-popup');
        const resetConfirmButton = document.getElementById('custom404-reset-confirm');
        const resetCancelButton = document.getElementById('custom404-reset-cancel');
        const mainForm = document.getElementById('custom404-main-form');

        if (!resetButton || !resetPopup || !resetConfirmButton || !resetCancelButton || !mainForm) {
            logError('Reset elements or main form not found for reset default setup.');
            return;
        }

        resetButton.addEventListener('click', () => {
            resetPopup.style.display = 'block';
            logDebug('Reset popup opened');
        });

        resetConfirmButton.addEventListener('click', () => {
            const formToken = mainForm.querySelector('input[name="form_token"]');
            if (!formToken || !formToken.value) {
                logError('Form token missing or empty during reset, reloading page');
                location.reload();
                return;
            }

            const titleInput = document.getElementById('custom404_title_key');
            const messageInput = document.getElementById('custom404_message_key');
            const imageAltInput = document.getElementById('custom404_image_alt_key');

            if (titleInput && messageInput && imageAltInput) {
                titleInput.value = lang.defaultTitle;
                messageInput.value = lang.defaultMessage;
                imageAltInput.value = lang.defaultImageAlt;
                logDebug('Form fields updated to default:', { title: lang.defaultTitle, message: lang.defaultMessage, imageAlt: lang.defaultImageAlt });
            } else {
                logError('Form fields missing for default reset.');
                return;
            }

            // Remove existing hidden input if any, then add new one
            mainForm.querySelector('input[name="reset_default"]')?.remove();
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'reset_default';
            hiddenInput.value = '1';
            mainForm.appendChild(hiddenInput);
            logDebug('Added reset_default hidden input');

            resetPopup.style.display = 'none';
            logDebug('Popup hidden before form submission');

            mainForm.submit(); // Submit the form
            logDebug('Main form submitted for reset_default action, form_token:', formToken.value || 'none');
        });

        resetCancelButton.addEventListener('click', () => {
            resetPopup.style.display = 'none'; // Changed from 'show' to 'none' as it should hide.
            logDebug('Reset cancelled');
        });
    };
    setupResetDefaultPopup();

    /**
     * Configura o popup de exclusão de imagem.
     */
    const setupDeleteImagePopup = () => {
        const deleteButton = document.getElementById('custom404-delete-button');
        const deletePopup = document.getElementById('custom404-delete-popup');
        const noImagePopup = document.getElementById('custom404-no-image-popup');
        const deleteConfirmButton = document.getElementById('custom404-delete-confirm');
        const deleteCancelButton = document.getElementById('custom404-delete-cancel');
        const noImageOkButton = document.getElementById('custom404-no-image-ok');
        const deleteImageSelect = document.getElementById('delete_image_path');
        const deleteForm = document.getElementById('delete-image-form');
        const errorContainer = document.querySelector('.custom404-acp .error');


        if (!deleteButton || !deletePopup || !noImagePopup || !deleteConfirmButton || !deleteCancelButton || !noImageOkButton || !deleteImageSelect || !deleteForm) {
            logError('Delete image elements not found for delete image setup.');
            return;
        }

        deleteButton.addEventListener('click', () => {
            logDebug('Delete button clicked, selected image:', deleteImageSelect.value);
            if (deleteImageSelect.value === '') {
                noImagePopup.style.display = 'block';
                logDebug('No image selected, showing no-image popup');
            } else {
                deletePopup.style.display = 'block';
                logDebug('Delete popup opened, selected image:', deleteImageSelect.value);
            }
        });

        deleteConfirmButton.addEventListener('click', () => {
            const deleteImagePathInput = deleteForm.querySelector('#delete_image_path_hidden');
            const deleteFormToken = deleteForm.querySelector('input[name="form_token"]');

            if (!deleteImagePathInput) {
                logError('delete_image_path_hidden input not found');
                if (errorContainer) {
                    errorContainer.textContent = lang.formTokenMissing;
                    errorContainer.style.display = 'block';
                } else {
                    alert(lang.formTokenMissing);
                }
                return;
            }
            deleteImagePathInput.value = deleteImageSelect.value;
            logDebug('Set delete_image_path_hidden to:', deleteImageSelect.value);


            if (!deleteFormToken || !deleteFormToken.value) {
                logError('Form token not found or empty in delete-image-form, reloading page');
                if (errorContainer) {
                    errorContainer.textContent = lang.formTokenMissing;
                    errorContainer.style.display = 'block';
                } else {
                    alert(lang.formTokenMissing);
                }
                location.reload();
                return;
            }

            deletePopup.style.display = 'none';
            logDebug('Popup hidden before form submission');

            // Add hidden input for delete_image
            let deleteImageInput = deleteForm.querySelector('input[name="delete_image"]');
            if (!deleteImageInput) {
                deleteImageInput = document.createElement('input');
                deleteImageInput.type = 'hidden';
                deleteImageInput.name = 'delete_image';
                deleteImageInput.value = '1';
                deleteForm.appendChild(deleteImageInput);
                logDebug('Added delete_image hidden input');
            }

            deleteForm.submit();
            logDebug('Delete form submitted for delete_image action, form_token:', deleteFormToken.value);
        });

        deleteCancelButton.addEventListener('click', () => {
            deletePopup.style.display = 'none';
            logDebug('Delete cancelled');
        });

        noImageOkButton.addEventListener('click', () => {
            noImagePopup.style.display = 'none';
            logDebug('No image popup closed');
        });
    };
    setupDeleteImagePopup();

    /**
     * Configura o popup de exclusão de logs e ações relacionadas a logs.
     */
    const setupLogsActions = () => {
        const deleteLogsButton = document.getElementById('custom404-delete-logs-button');
        const deleteLogsPopup = document.getElementById('custom404-delete-logs-popup');
        const deleteLogsConfirmButton = document.getElementById('custom404-delete-logs-confirm');
        const deleteLogsCancelButton = document.getElementById('custom404-delete-logs-cancel');
        const logsForm = document.querySelector('.custom404-logs-actions form');
        const logLimitSelect = document.getElementById('log_limit');
        const searchLogsButton = document.querySelector('input[name="search_logs"]');
        const clearSearchButton = document.querySelector('input[name="clear_search"]');
        const logSearchInput = document.getElementById('log_search');

        if (!logsForm) {
            logError('Logs form not found.');
            return;
        }

        // Delete Logs Popup
        if (deleteLogsButton && deleteLogsPopup && deleteLogsConfirmButton && deleteLogsCancelButton) {
            deleteLogsButton.addEventListener('click', () => {
                deleteLogsPopup.style.display = 'block';
                logDebug('Delete logs popup opened');
            });

            deleteLogsConfirmButton.addEventListener('click', () => {
                const deleteLogsInput = document.createElement('input');
                deleteLogsInput.type = 'hidden';
                deleteLogsInput.name = 'delete_logs';
                deleteLogsInput.value = '1';
                logsForm.appendChild(deleteLogsInput);
                deleteLogsPopup.style.display = 'none';
                logDebug('Popup hidden before logs form submission');
                logsForm.submit();
                logDebug('Logs form submitted for delete_logs action');
            });

            deleteLogsCancelButton.addEventListener('click', () => {
                deleteLogsPopup.style.display = 'none';
                logDebug('Delete logs cancelled');
            });
        } else {
            logDebug('Delete logs elements not fully found, skipping setup.');
        }

        // Log Limit Change
        if (logLimitSelect) {
            logLimitSelect.addEventListener('change', () => {
                logDebug('Log limit changed:', logLimitSelect.value);
                logsForm.submit();
                logDebug('Logs form submitted for log_limit change');
            });
        } else {
            logDebug('Log limit select not found, skipping setup.');
        }

        // Search Logs
        if (searchLogsButton) {
            searchLogsButton.addEventListener('click', () => {
                logDebug('Search logs button clicked');
                logsForm.submit();
                logDebug('Logs form submitted for search_logs action');
            });
        } else {
            logDebug('Search logs button not found, skipping setup.');
        }

        // Clear Search
        if (clearSearchButton && logSearchInput) {
            clearSearchButton.addEventListener('click', (e) => {
                e.preventDefault();
                logSearchInput.value = '';
                logSearchInput.placeholder = lang.logSearchPlaceholder;
                logDebug('Clear search triggered, input cleared and placeholder restored');

                const clearSearchInput = document.createElement('input');
                clearSearchInput.type = 'hidden';
                clearSearchInput.name = 'clear_search';
                clearSearchInput.value = '1';
                logsForm.appendChild(clearSearchInput);

                logsForm.submit();
                logDebug('Logs form submitted for clear_search action');
            });
        } else {
            logDebug('Clear search elements not fully found, skipping setup.');
        }
    };
    setupLogsActions();

    /**
     * Configura os toggles de tema, modo de depuração e exibição de imagem.
     * @param {HTMLElement} toggleElement - O elemento do botão de alternância.
     * @param {HTMLElement} hiddenInputElement - O input hidden associado.
     * @param {string} keyPrefix - Prefixo para as chaves de tradução (ex: 'lAcpCustom404Theme').
     * @param {string} dataAttribute - O nome do atributo de dados (ex: 'data-theme').
     * @param {Object} valueMap - Um mapa de valores para o texto do botão (ex: { 'light': lang.lAcpCustom404ThemeLight, 'dark': lang.lAcpCustom404ThemeDark }).
     */
    const setupToggle = (toggleElement, hiddenInputElement, keyOn, keyOff, dataAttribute) => {
        if (!toggleElement || !hiddenInputElement) {
            logError('Toggle elements not found for keyPrefix:', keyOn, keyOff);
            return;
        }

        const updateToggleState = () => {
            const isOn = hiddenInputElement.value === '1' || hiddenInputElement.value === 'dark';
            toggleElement.textContent = isOn ? lang[keyOn] : lang[keyOff];
            toggleElement.setAttribute(dataAttribute, hiddenInputElement.value);
        };

        toggleElement.addEventListener('click', () => {
            const isCurrentlyOn = hiddenInputElement.value === '1' || hiddenInputElement.value === 'dark';
            hiddenInputElement.value = isCurrentlyOn ? (hiddenInputElement.value === '1' ? '0' : 'light') : (hiddenInputElement.value === '0' ? '1' : 'dark');
            updateToggleState();
            logDebug(`${dataAttribute} toggled to:`, hiddenInputElement.value);
        });

        updateToggleState(); // Initial state setup
    };

    setupToggle(
        document.getElementById('custom404_theme_toggle'),
        document.getElementById('custom404_theme_hidden'),
        'lAcpCustom404ThemeDark', // Texto para quando o tema é "dark"
        'lAcpCustom404ThemeLight', // Texto para quando o tema é "light"
        'data-theme'
    );

    setupToggle(
        document.getElementById('custom404_debug_toggle'),
        document.getElementById('custom404_debug_mode_hidden'),
        'lAcpCustom404DebugModeOn',
        'lAcpCustom404DebugModeOff',
        'data-debug'
    );

    setupToggle(
        document.getElementById('custom404_show_image_toggle'),
        document.getElementById('custom404_show_image_hidden'),
        'lAcpCustom404ShowImageOn',
        'lAcpCustom404ShowImageOff',
        'data-show-image'
    );
});