/**
 * Simple Block Extensions for Silly Goose Theme
 * Adds width controls to blocks safely
 */

(function() {
    'use strict';

    // Only proceed if WordPress components are available
    if (!window.wp || !wp.hooks || !wp.element || !wp.components) {
        console.warn('Silly Goose: WordPress components not available, skipping block extensions');
        return;
    }

    const { addFilter } = wp.hooks;
    const { Fragment, createElement } = wp.element;
    const { InspectorControls } = wp.blockEditor || wp.editor;
    const { PanelBody, SelectControl } = wp.components;
    const { createHigherOrderComponent } = wp.compose;

    // Only add width controls to core WordPress blocks to avoid conflicts
    const supportedBlocks = [
        'core/group',
        'core/columns',
        'core/cover',
        'core/media-text',
        'core/gallery',
        'core/image',
        'core/heading',
        'core/paragraph',
        'core/quote',
        'core/pullquote',
        'core/table',
        'core/verse',
        'core/code',
        'core/preformatted',
        'core/embed',
        'core/separator',
        'core/spacer',
        'core/buttons',
        'core/list'
        // Excluding all sillygoose/* blocks to prevent conflicts
    ];

    /**
     * Add containerWidth attribute to supported blocks
     */
    function addWidthAttribute(settings, name) {
        if (supportedBlocks.includes(name)) {
            settings.attributes = {
                ...settings.attributes,
                containerWidth: {
                    type: 'string',
                    default: 'centered'
                }
            };
        }
        return settings;
    }

    /**
     * Add width control to block inspector
     */
    const withWidthControl = createHigherOrderComponent((BlockEdit) => {
        return (props) => {
            const { attributes, setAttributes, name } = props;
            
            // Only add control to supported blocks
            if (!supportedBlocks.includes(name)) {
                return createElement(BlockEdit, props);
            }

            const { containerWidth = 'centered' } = attributes;

            return createElement(Fragment, {},
                createElement(BlockEdit, props),
                createElement(InspectorControls, {},
                    createElement(PanelBody, {
                        title: 'Layout Settings',
                        initialOpen: false
                    },
                        createElement(SelectControl, {
                            label: 'Container Width',
                            value: containerWidth,
                            options: [
                                { label: 'Centered (1200px)', value: 'centered' },
                                { label: 'Full Width', value: 'full' }
                            ],
                            onChange: (value) => setAttributes({ containerWidth: value }),
                            help: 'Choose how wide this block should be'
                        })
                    )
                )
            );
        };
    }, 'withWidthControl');

    /**
     * Add CSS classes based on width setting
     */
    function addWidthClasses(extraProps, blockType, attributes) {
        if (!supportedBlocks.includes(blockType.name)) {
            return extraProps;
        }

        const { containerWidth = 'centered' } = attributes;
        
        const widthClass = containerWidth === 'full' ? 'sg-container-full' : 'sg-container-centered';
        
        extraProps.className = extraProps.className 
            ? `${extraProps.className} ${widthClass}` 
            : widthClass;

        return extraProps;
    }

    // Apply filters only if we have the required functions
    if (typeof addFilter === 'function') {
        addFilter(
            'blocks.registerBlockType',
            'sillygoose/add-width-attribute',
            addWidthAttribute
        );

        addFilter(
            'editor.BlockEdit',
            'sillygoose/with-width-control',
            withWidthControl
        );

        addFilter(
            'blocks.getSaveContent.extraProps',
            'sillygoose/add-width-classes',
            addWidthClasses
        );
    }

    // Add basic editor styles
    wp.domReady(() => {
        const style = document.createElement('style');
        style.textContent = `
            .sg-container-centered {
                max-width: 1200px;
                margin-left: auto;
                margin-right: auto;
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .sg-container-full {
                width: 100%;
                max-width: none;
            }
        `;
        document.head.appendChild(style);
    });

})();