/**
 * Silly Goose Statistics Block
 * Dynamic statistics block with add/remove functionality and rotating colors
 */

(function() {
    'use strict';

    const { registerBlockType } = wp.blocks;
    const { createElement, Fragment } = wp.element;
    const { InspectorControls, useBlockProps } = wp.blockEditor;
    const { PanelBody, Button, TextControl, SelectControl } = wp.components;
    const { __ } = wp.i18n;

    // Color rotation based on your theme colors
    const colorRotation = ['primary', 'secondary', 'accent']; // Orange, Teal, Yellow
    const colorValues = {
        'primary': '#ff6b35',
        'secondary': '#4ecdc4', 
        'accent': '#ffd23f'
    };

    // Register the statistics block
    registerBlockType('sillygoose/statistics', {
        title: __('Silly Goose Statistics', 'sillygoose'),
        icon: 'chart-bar',
        category: 'sillygoose',
        description: __('Display statistics with rotating brand colors and dynamic add/remove functionality', 'sillygoose'),
        keywords: ['stats', 'statistics', 'numbers', 'metrics'],
        
        attributes: {
            statistics: {
                type: 'array',
                default: [
                    { statText: '150+', description: 'Projects Completed' },
                    { statText: '50+', description: 'Happy Clients' },
                    { statText: '5★', description: 'Average Rating' }
                ]
            },
            backgroundColor: {
                type: 'string',
                default: 'muted'
            },
            containerWidth: {
                type: 'string',
                default: 'contained'
            }
        },

        edit: function(props) {
            const { attributes, setAttributes } = props;
            const { statistics, backgroundColor, containerWidth } = attributes;

            const blockProps = useBlockProps({
                className: `sillygoose-statistics-block ${containerWidth === 'full' ? 'stats-full-width' : 'stats-contained'}`
            });

            // Function to add a new statistic
            const addStatistic = () => {
                const newStats = [...statistics, { statText: '', description: '' }];
                setAttributes({ statistics: newStats });
            };

            // Function to remove a statistic
            const removeStatistic = (index) => {
                const newStats = statistics.filter((_, i) => i !== index);
                setAttributes({ statistics: newStats });
            };

            // Function to update a statistic
            const updateStatistic = (index, field, value) => {
                const newStats = [...statistics];
                newStats[index][field] = value;
                setAttributes({ statistics: newStats });
            };

            // Get color class for index
            const getColorClass = (index) => {
                return colorRotation[index % colorRotation.length];
            };

            // Get color value for preview
            const getColorValue = (index) => {
                const colorClass = getColorClass(index);
                return colorValues[colorClass];
            };

            return createElement(Fragment, {},
                // Inspector Controls (sidebar)
                createElement(InspectorControls, {},
                    createElement(PanelBody, {
                        title: __('Layout Settings', 'sillygoose'),
                        initialOpen: true
                    },
                        createElement(SelectControl, {
                            label: __('Container Width', 'sillygoose'),
                            value: containerWidth,
                            options: [
                                { label: 'Contained (1200px max)', value: 'contained' },
                                { label: 'Full Width (100%)', value: 'full' }
                            ],
                            onChange: (value) => setAttributes({ containerWidth: value })
                        }),
                        createElement(SelectControl, {
                            label: __('Background Color', 'sillygoose'),
                            value: backgroundColor,
                            options: [
                                { label: 'Muted Gray', value: 'muted' },
                                { label: 'White', value: 'white' },
                                { label: 'Primary Orange', value: 'primary' },
                                { label: 'Foreground Dark', value: 'foreground' }
                            ],
                            onChange: (value) => setAttributes({ backgroundColor: value })
                        })
                    ),
                    
                    createElement(PanelBody, {
                        title: __('Statistics Management', 'sillygoose'),
                        initialOpen: true
                    },
                        statistics.map((stat, index) =>
                            createElement('div', {
                                key: index,
                                style: {
                                    marginBottom: '1rem',
                                    padding: '1rem',
                                    border: '1px solid #ddd',
                                    borderRadius: '4px',
                                    position: 'relative'
                                }
                            },
                                createElement('div', {
                                    style: {
                                        display: 'flex',
                                        alignItems: 'center',
                                        marginBottom: '0.5rem'
                                    }
                                },
                                    createElement('div', {
                                        style: {
                                            width: '20px',
                                            height: '20px',
                                            borderRadius: '50%',
                                            backgroundColor: getColorValue(index),
                                            marginRight: '0.5rem'
                                        }
                                    }),
                                    createElement('strong', {}, `Stat ${index + 1}`)
                                ),
                                createElement(TextControl, {
                                    label: __('Statistic Text', 'sillygoose'),
                                    value: stat.statText,
                                    onChange: (value) => updateStatistic(index, 'statText', value),
                                    placeholder: __('e.g., 150+', 'sillygoose')
                                }),
                                createElement(TextControl, {
                                    label: __('Description', 'sillygoose'),
                                    value: stat.description,
                                    onChange: (value) => updateStatistic(index, 'description', value),
                                    placeholder: __('e.g., Projects Completed', 'sillygoose')
                                }),
                                statistics.length > 1 && createElement(Button, {
                                    isDestructive: true,
                                    isSmall: true,
                                    onClick: () => removeStatistic(index),
                                    style: { marginTop: '0.5rem' }
                                }, __('Remove Stat', 'sillygoose'))
                            )
                        ),
                        createElement(Button, {
                            isPrimary: true,
                            onClick: addStatistic,
                            style: { marginTop: '1rem' }
                        }, __('Add Statistic', 'sillygoose'))
                    )
                ),

                // Block content in editor
                createElement('div', blockProps,
                    createElement('div', {
                        className: 'stats-preview',
                        style: {
                            padding: '2rem',
                            backgroundColor: backgroundColor === 'muted' ? '#f8f9fa' : 
                                           backgroundColor === 'primary' ? '#ff6b35' :
                                           backgroundColor === 'foreground' ? '#212529' : '#ffffff',
                            color: backgroundColor === 'foreground' ? 'white' : '#212529',
                            borderRadius: '0.625rem',
                            border: '2px dashed #ddd'
                        }
                    },
                        createElement('div', {
                            style: {
                                display: 'grid',
                                gridTemplateColumns: `repeat(auto-fit, minmax(200px, 1fr))`,
                                gap: '2rem',
                                maxWidth: containerWidth === 'full' ? '100%' : '1200px',
                                margin: '0 auto'
                            }
                        },
                            statistics.map((stat, index) =>
                                createElement('div', {
                                    key: index,
                                    className: 'stat-item',
                                    style: {
                                        textAlign: 'center',
                                        padding: '1rem'
                                    }
                                },
                                    createElement('div', {
                                        className: 'stat-number',
                                        style: {
                                            fontSize: '3rem',
                                            fontWeight: '900',
                                            marginBottom: '0.5rem',
                                            color: getColorValue(index)
                                        }
                                    }, stat.statText || __('Enter stat...', 'sillygoose')),
                                    createElement('div', {
                                        className: 'stat-description',
                                        style: {
                                            fontSize: '1rem',
                                            color: backgroundColor === 'foreground' ? '#d1d5db' : '#6c757d'
                                        }
                                    }, stat.description || __('Enter description...', 'sillygoose'))
                                )
                            )
                        )
                    )
                )
            );
        },

        save: function() {
            // This block is rendered server-side
            return null;
        }
    });

})();