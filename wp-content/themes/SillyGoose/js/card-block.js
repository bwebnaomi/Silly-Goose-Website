/**
 * Silly Goose Card Block - Fixed Version
 * Custom block for displaying projects, services, and posts cards
 */

(function() {
    'use strict';

    const { registerBlockType } = wp.blocks;
    const { createElement, Fragment } = wp.element;
    const { InspectorControls, useBlockProps } = wp.blockEditor;
    const { PanelBody, SelectControl, RangeControl, TextControl } = wp.components;
    const { useSelect } = wp.data;
    const { __ } = wp.i18n;

    // Register the custom card block
    registerBlockType('sillygoose/card-block', {
        title: __('Silly Goose Cards', 'sillygoose'),
        icon: 'grid-view',
        category: 'sillygoose',
        description: __('Display a customisable grid of portfolio, service, or blog post cards', 'sillygoose'),
        keywords: ['cards', 'portfolio', 'services', 'posts', 'blog', 'grid'],
        
        attributes: {
            postType: {
                type: 'string',
                default: 'portfolio'
            },
            numberOfPosts: {
                type: 'number',
                default: 3
            },
            title: {
                type: 'string',
                default: ''
            },
            description: {
                type: 'string',
                default: ''
            },
            titleTag: {
                type: 'string',
                default: 'h2'
            },
            orderBy: {
                type: 'string',
                default: 'date'
            },
            order: {
                type: 'string',
                default: 'desc'
            }
        },

        edit: function(props) {
            const { attributes, setAttributes } = props;
            const { postType, numberOfPosts, title, description, titleTag, orderBy, order } = attributes;
            
            // More robust data fetching with error handling
            const { posts, isLoading, hasError } = useSelect((select) => {
                const query = {
                    per_page: numberOfPosts,
                    status: 'publish',
                    _embed: true
                };

                // Add order parameters only if they're valid
                if (orderBy) {
                    query.orderby = orderBy;
                }
                if (order && (order === 'asc' || order === 'desc')) {
                    query.order = order;
                }

                try {
                    const data = select('core').getEntityRecords('postType', postType, query);
                    const loading = select('core/data').isResolving('core', 'getEntityRecords', ['postType', postType, query]);
                    const error = select('core/data').hasFinishedResolution('core', 'getEntityRecords', ['postType', postType, query]) && !data;
                    
                    return {
                        posts: data,
                        isLoading: loading,
                        hasError: error
                    };
                } catch (e) {
                    return {
                        posts: null,
                        isLoading: false,
                        hasError: true
                    };
                }
            }, [postType, numberOfPosts, orderBy, order]);

            const blockProps = useBlockProps({
                className: 'sillygoose-card-block'
            });

            // Render function for individual cards
            const renderCard = (post, index) => {
                // Get different fields based on post type
                const getPostMeta = (metaKey, fallback = '') => {
                    return post.meta && post.meta[metaKey] ? post.meta[metaKey] : fallback;
                };

                // Different handling for different post types
                let categoryLabel = '';
                let resultLabel = '';
                let cardClass = 'card-item';

                if (postType === 'portfolio') {
                    categoryLabel = getPostMeta('portfolio_category', 'Portfolio');
                    resultLabel = getPostMeta('portfolio_result', '');
                    cardClass += ' portfolio-card';
                } else if (postType === 'service') {
                    categoryLabel = getPostMeta('service_category', 'Service');
                    resultLabel = getPostMeta('service_result', '');
                    cardClass += ' service-card';
                } else if (postType === 'post') {
                    // For blog posts, get categories
                    if (post._embedded && post._embedded['wp:term'] && post._embedded['wp:term'][0]) {
                        const categories = post._embedded['wp:term'][0];
                        categoryLabel = categories && categories.length > 0 ? categories[0].name : 'Blog Post';
                    } else {
                        categoryLabel = 'Blog Post';
                    }
                    
                    // For posts, show publish date instead of result
                    if (post.date) {
                        const publishDate = new Date(post.date);
                        resultLabel = publishDate.toLocaleDateString('en-GB', { 
                            year: 'numeric', 
                            month: 'short', 
                            day: 'numeric' 
                        });
                    }
                    cardClass += ' blog-card';
                }

                return createElement('div', { 
                    key: post.id || index, 
                    className: cardClass,
                    style: {
                        border: '1px solid #e5e7eb',
                        borderRadius: '0.5rem',
                        overflow: 'hidden',
                        background: 'white',
                        boxShadow: '0 1px 3px rgba(0,0,0,0.1)'
                    }
                },
                    // Featured Image placeholder
                    createElement('div', {
                        style: {
                            width: '100%',
                            height: '200px',
                            background: '#f3f4f6',
                            display: 'flex',
                            alignItems: 'center',
                            justifyContent: 'center',
                            fontSize: '0.875rem',
                            color: '#6b7280'
                        }
                    }, post.featured_media ? 'Featured Image' : 'No Image'),

                    // Card Content
                    createElement('div', { 
                        style: { 
                            padding: '1.5rem' 
                        } 
                    },
                        // Category Badge
                        categoryLabel && createElement('span', {
                            style: {
                                background: postType === 'post' ? '#10b981' : (postType === 'portfolio' ? '#f59e0b' : '#06b6d4'),
                                color: 'white',
                                padding: '0.25rem 0.75rem',
                                borderRadius: '9999px',
                                fontSize: '0.75rem',
                                fontWeight: '600',
                                marginBottom: '1rem',
                                display: 'inline-block'
                            }
                        }, categoryLabel),

                        // Title
                        createElement('h3', {
                            style: {
                                fontSize: '1.25rem',
                                fontWeight: '600',
                                marginBottom: '0.75rem',
                                lineHeight: '1.4'
                            }
                        }, post.title && post.title.rendered ? post.title.rendered : 'Untitled'),

                        // Excerpt
                        createElement('p', {
                            style: {
                                color: '#6b7280',
                                fontSize: '0.875rem',
                                lineHeight: '1.6',
                                marginBottom: '1rem'
                            }
                        }, post.excerpt && post.excerpt.rendered ? 
                            post.excerpt.rendered.replace(/<[^>]*>/g, '').substring(0, 100) + '...' : 
                            'No excerpt available...'
                        ),

                        // Result/Date
                        resultLabel && createElement('div', {
                            style: {
                                fontSize: '0.875rem',
                                display: 'flex',
                                alignItems: 'center',
                                justifyContent: 'space-between'
                            }
                        },
                            createElement('span', {},
                                createElement('span', { 
                                    style: { color: '#6b7280' } 
                                }, postType === 'post' ? 'Published: ' : 'Result: '),
                                createElement('span', { 
                                    style: { fontWeight: '500', color: '#f59e0b' } 
                                }, resultLabel)
                            ),
                            // External link icon
                            createElement('svg', {
                                style: { width: '1rem', height: '1rem', color: '#6b7280' },
                                fill: 'none',
                                stroke: 'currentColor',
                                viewBox: '0 0 24 24'
                            },
                                createElement('path', {
                                    strokeLinecap: 'round',
                                    strokeLinejoin: 'round',
                                    strokeWidth: '2',
                                    d: 'M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14'
                                })
                            )
                        )
                    )
                );
            };

            return createElement(Fragment, {},
                // Inspector Controls (sidebar)
                createElement(InspectorControls, {},
                    createElement(PanelBody, {
                        title: __('Card Settings', 'sillygoose'),
                        initialOpen: true
                    },
                        createElement(SelectControl, {
                            label: __('Post Type', 'sillygoose'),
                            value: postType,
                            options: [
                                { label: 'Portfolio', value: 'portfolio' },
                                { label: 'Services', value: 'service' },
                                { label: 'Blog Posts', value: 'post' }
                            ],
                            onChange: (value) => setAttributes({ postType: value })
                        }),
                        createElement(RangeControl, {
                            label: __('Number of Cards', 'sillygoose'),
                            value: numberOfPosts,
                            onChange: (value) => setAttributes({ numberOfPosts: value }),
                            min: 1,
                            max: 12
                        }),
                        createElement(SelectControl, {
                            label: __('Order By', 'sillygoose'),
                            value: orderBy,
                            options: [
                                { label: 'Date', value: 'date' },
                                { label: 'Title', value: 'title' },
                                { label: 'Menu Order', value: 'menu_order' },
                                { label: 'Random', value: 'rand' }
                            ],
                            onChange: (value) => setAttributes({ orderBy: value })
                        }),
                        createElement(SelectControl, {
                            label: __('Order', 'sillygoose'),
                            value: order,
                            options: [
                                { label: 'Descending (Newest First)', value: 'desc' },
                                { label: 'Ascending (Oldest First)', value: 'asc' }
                            ],
                            onChange: (value) => setAttributes({ order: value })
                        })
                    ),
                    createElement(PanelBody, {
                        title: __('Content Settings', 'sillygoose'),
                        initialOpen: false
                    },
                        createElement(TextControl, {
                            label: __('Section Title', 'sillygoose'),
                            value: title,
                            onChange: (value) => setAttributes({ title: value }),
                            placeholder: __('Enter section title...', 'sillygoose')
                        }),
                        createElement(SelectControl, {
                            label: __('Title Tag', 'sillygoose'),
                            value: titleTag,
                            options: [
                                { label: 'H1', value: 'h1' },
                                { label: 'H2', value: 'h2' },
                                { label: 'H3', value: 'h3' },
                                { label: 'H4', value: 'h4' },
                                { label: 'H5', value: 'h5' },
                                { label: 'H6', value: 'h6' }
                            ],
                            onChange: (value) => setAttributes({ titleTag: value })
                        }),
                        createElement(TextControl, {
                            label: __('Description', 'sillygoose'),
                            value: description,
                            onChange: (value) => setAttributes({ description: value }),
                            placeholder: __('Enter section description...', 'sillygoose')
                        })
                    )
                ),

                // Block content
                createElement('div', blockProps,
                    // Section header
                    title && createElement('div', { className: 'card-block-header', style: { marginBottom: '2rem', textAlign: 'center' } },
                        createElement(titleTag, { 
                            className: 'card-block-title',
                            style: { 
                                fontSize: '2rem', 
                                fontWeight: 'bold', 
                                marginBottom: '1rem',
                                margin: '0 0 1rem 0' 
                            }
                        }, title),
                        description && createElement('p', { 
                            className: 'card-block-description',
                            style: { 
                                fontSize: '1.125rem', 
                                color: '#6b7280',
                                margin: '0' 
                            }
                        }, description)
                    ),

                    // Status messages
                    hasError && createElement('div', {
                        style: {
                            padding: '1rem',
                            background: '#fef2f2',
                            border: '1px solid #fecaca',
                            borderRadius: '0.5rem',
                            color: '#dc2626',
                            textAlign: 'center'
                        }
                    }, `Error loading ${postType}. Please check if the post type exists and has published content.`),

                    isLoading && createElement('div', {
                        style: {
                            padding: '2rem',
                            textAlign: 'center',
                            color: '#6b7280'
                        }
                    }, `Loading ${postType}...`),

                    // Cards grid
                    !hasError && !isLoading && createElement('div', { 
                        className: `card-grid`,
                        style: { 
                            display: 'grid',
                            gridTemplateColumns: `repeat(auto-fit, minmax(300px, 1fr))`,
                            gap: '1.5rem'
                        }
                    },
                        posts && posts.length > 0 ? posts.map(renderCard) : 
                        !isLoading && createElement('div', {
                            style: {
                                padding: '2rem',
                                textAlign: 'center',
                                color: '#6b7280',
                                gridColumn: '1 / -1'
                            }
                        }, `No ${postType} found. Try creating some content first!`)
                    )
                )
            );
        },

        save: function() {
            // Return null since this is a dynamic block
            return null;
        }
    });

})();