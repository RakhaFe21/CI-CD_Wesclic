@extends('layouts.master')
@section('title','Page Content Edit')
@section('page-style')
<script src="http://editor.unlayer.com/embed.js"></script>
@endsection
@section('content')


<button id="update_html_btn" class="btn btn-primary">Update Page</button>

<div id="editor" style="height: 79vh;"></div>


@endsection


@section('page-script')
<script>
    unlayer.init({
        id: 'editor',
        displayMode: 'web',
        customCSS: ['.blockbuilder-preview {  background-color: yellow !important;  background-image: none !important;}'],
    });

    unlayer.loadDesign({
        "body": {
            "rows": [{
                "cells": ["1"],
                "columns": [{
                    "contents": [{
                        "type": "button",
                        "values": {
                            "containerPadding": "10px",
                            "_meta": {
                                "htmlID": "u_content_button_1",
                                "htmlClassNames": "u_content_button"
                            },
                            "selectable": "true",
                            "draggable": "true",
                            "duplicatable": "true",
                            "deletable": "true",
                            "href": {
                                "name": "web",
                                "values": {
                                    "href": null,
                                    "target": "_blank"
                                }
                            },
                            "buttonColors": {
                                "color": "#FFFFFF",
                                "backgroundColor": "#3AAEE0",
                                "hoverColor": "#FFFFFF",
                                "hoverBackgroundColor": "#3AAEE0"
                            },
                            "size": {
                                "autoWidth": "true",
                                "width": "100%"
                            },
                            "textAlign": "center",
                            "lineHeight": "120%",
                            "padding": "10px 20px",
                            "borderRadius": "4px",
                            "hideDesktop": "false",
                            "hideMobile": "false",
                            "text": "<span style=\"font-size: 14px; line-height: 16.8px;\">Button Text<\/span>"
                        }
                    }, {
                        "type": "button",
                        "values": {
                            "containerPadding": "10px",
                            "_meta": {
                                "htmlID": "u_content_button_2",
                                "htmlClassNames": "u_content_button"
                            },
                            "selectable": "true",
                            "draggable": "true",
                            "duplicatable": "true",
                            "deletable": "true",
                            "href": {
                                "name": "web",
                                "values": {
                                    "href": null,
                                    "target": "_blank"
                                }
                            },
                            "buttonColors": {
                                "color": "#FFFFFF",
                                "backgroundColor": "#3AAEE0",
                                "hoverColor": "#FFFFFF",
                                "hoverBackgroundColor": "#3AAEE0"
                            },
                            "size": {
                                "autoWidth": "true",
                                "width": "100%"
                            },
                            "textAlign": "center",
                            "lineHeight": "120%",
                            "padding": "10px 20px",
                            "borderRadius": "4px",
                            "hideDesktop": "false",
                            "hideMobile": "false",
                            "text": "<span style=\"font-size: 14px; line-height: 16.8px;\">Button Text<\/span>"
                        }
                    }, {
                        "type": "button",
                        "values": {
                            "containerPadding": "10px",
                            "_meta": {
                                "htmlID": "u_content_button_3",
                                "htmlClassNames": "u_content_button"
                            },
                            "selectable": "true",
                            "draggable": "true",
                            "duplicatable": "true",
                            "deletable": "true",
                            "href": {
                                "name": "web",
                                "values": {
                                    "href": null,
                                    "target": "_blank"
                                }
                            },
                            "buttonColors": {
                                "color": "#FFFFFF",
                                "backgroundColor": "#3AAEE0",
                                "hoverColor": "#FFFFFF",
                                "hoverBackgroundColor": "#3AAEE0"
                            },
                            "size": {
                                "autoWidth": "true",
                                "width": "100%"
                            },
                            "textAlign": "center",
                            "lineHeight": "120%",
                            "padding": "10px 20px",
                            "borderRadius": "4px",
                            "hideDesktop": "false",
                            "hideMobile": "false",
                            "text": "<span style=\"font-size: 14px; line-height: 16.8px;\">Button Text<\/span>"
                        }
                    }, {
                        "type": "button",
                        "values": {
                            "containerPadding": "10px",
                            "_meta": {
                                "htmlID": "u_content_button_4",
                                "htmlClassNames": "u_content_button"
                            },
                            "selectable": "true",
                            "draggable": "true",
                            "duplicatable": "true",
                            "deletable": "true",
                            "href": {
                                "name": "web",
                                "values": {
                                    "href": null,
                                    "target": "_blank"
                                }
                            },
                            "buttonColors": {
                                "color": "#FFFFFF",
                                "backgroundColor": "#3AAEE0",
                                "hoverColor": "#FFFFFF",
                                "hoverBackgroundColor": "#3AAEE0"
                            },
                            "size": {
                                "autoWidth": "true",
                                "width": "100%"
                            },
                            "textAlign": "center",
                            "lineHeight": "120%",
                            "padding": "10px 20px",
                            "borderRadius": "4px",
                            "hideDesktop": "false",
                            "hideMobile": "false",
                            "text": "<span style=\"font-size: 14px; line-height: 16.8px;\">Button Text<\/span>"
                        }
                    }, {
                        "type": "button",
                        "values": {
                            "containerPadding": "10px",
                            "_meta": {
                                "htmlID": "u_content_button_6",
                                "htmlClassNames": "u_content_button"
                            },
                            "selectable": "true",
                            "draggable": "true",
                            "duplicatable": "true",
                            "deletable": "true",
                            "href": {
                                "name": "web",
                                "values": {
                                    "href": null,
                                    "target": "_blank"
                                }
                            },
                            "buttonColors": {
                                "color": "#FFFFFF",
                                "backgroundColor": "#3AAEE0",
                                "hoverColor": "#FFFFFF",
                                "hoverBackgroundColor": "#3AAEE0"
                            },
                            "size": {
                                "autoWidth": "true",
                                "width": "100%"
                            },
                            "textAlign": "center",
                            "lineHeight": "120%",
                            "padding": "10px 20px",
                            "borderRadius": "4px",
                            "hideDesktop": "false",
                            "hideMobile": "false",
                            "text": "<span style=\"font-size: 14px; line-height: 16.8px;\">Button Text<\/span>"
                        }
                    }, {
                        "type": "button",
                        "values": {
                            "containerPadding": "10px",
                            "_meta": {
                                "htmlID": "u_content_button_7",
                                "htmlClassNames": "u_content_button"
                            },
                            "selectable": "true",
                            "draggable": "true",
                            "duplicatable": "true",
                            "deletable": "true",
                            "href": {
                                "name": "web",
                                "values": {
                                    "href": null,
                                    "target": "_blank"
                                }
                            },
                            "buttonColors": {
                                "color": "#FFFFFF",
                                "backgroundColor": "#3AAEE0",
                                "hoverColor": "#FFFFFF",
                                "hoverBackgroundColor": "#3AAEE0"
                            },
                            "size": {
                                "autoWidth": "true",
                                "width": "100%"
                            },
                            "textAlign": "center",
                            "lineHeight": "120%",
                            "padding": "10px 20px",
                            "borderRadius": "4px",
                            "hideDesktop": "false",
                            "hideMobile": "false",
                            "text": "<span style=\"font-size: 14px; line-height: 16.8px;\">Button Text<\/span>"
                        }
                    }, {
                        "type": "button",
                        "values": {
                            "containerPadding": "10px",
                            "_meta": {
                                "htmlID": "u_content_button_5",
                                "htmlClassNames": "u_content_button"
                            },
                            "selectable": "true",
                            "draggable": "true",
                            "duplicatable": "true",
                            "deletable": "true",
                            "href": {
                                "name": "web",
                                "values": {
                                    "href": null,
                                    "target": "_blank"
                                }
                            },
                            "buttonColors": {
                                "color": "#FFFFFF",
                                "backgroundColor": "#3AAEE0",
                                "hoverColor": "#FFFFFF",
                                "hoverBackgroundColor": "#3AAEE0"
                            },
                            "size": {
                                "autoWidth": "true",
                                "width": "100%"
                            },
                            "textAlign": "center",
                            "lineHeight": "120%",
                            "padding": "10px 20px",
                            "borderRadius": "4px",
                            "hideDesktop": "false",
                            "hideMobile": "false",
                            "text": "<span style=\"font-size: 14px; line-height: 16.8px;\">Button Text<\/span>"
                        }
                    }, {
                        "type": "button",
                        "values": {
                            "containerPadding": "10px",
                            "_meta": {
                                "htmlID": "u_content_button_8",
                                "htmlClassNames": "u_content_button"
                            },
                            "selectable": "true",
                            "draggable": "true",
                            "duplicatable": "true",
                            "deletable": "true",
                            "href": {
                                "name": "web",
                                "values": {
                                    "href": null,
                                    "target": "_blank"
                                }
                            },
                            "buttonColors": {
                                "color": "#FFFFFF",
                                "backgroundColor": "#3AAEE0",
                                "hoverColor": "#FFFFFF",
                                "hoverBackgroundColor": "#3AAEE0"
                            },
                            "size": {
                                "autoWidth": "true",
                                "width": "100%"
                            },
                            "textAlign": "center",
                            "lineHeight": "120%",
                            "padding": "10px 20px",
                            "borderRadius": "4px",
                            "hideDesktop": "false",
                            "hideMobile": "false",
                            "text": "<span style=\"font-size: 14px; line-height: 16.8px;\">Button Text<\/span>"
                        }
                    }],
                    "values": {
                        "backgroundColor": "#ffffff",
                        "padding": "0px",
                        "_meta": {
                            "htmlID": "u_column_1",
                            "htmlClassNames": "u_column"
                        }
                    }
                }],
                "values": {
                    "displayCondition": null,
                    "columns": "false",
                    "backgroundColor": null,
                    "columnsBackgroundColor": null,
                    "backgroundImage": {
                        "url": null,
                        "fullWidth": "true",
                        "repeat": "false",
                        "center": "true",
                        "cover": "false"
                    },
                    "padding": "0px",
                    "hideDesktop": "false",
                    "hideMobile": "false",
                    "noStackMobile": "false",
                    "_meta": {
                        "htmlID": "u_row_1",
                        "htmlClassNames": "u_row"
                    },
                    "selectable": "true",
                    "draggable": "true",
                    "duplicatable": "true",
                    "deletable": "true"
                }
            }],
            "values": {
                "backgroundColor": "#e7e7e7",
                "backgroundImage": {
                    "url": null,
                    "fullWidth": "true",
                    "repeat": "false",
                    "center": "true",
                    "cover": "false"
                },
                "contentWidth": "500px",
                "contentAlign": "center",
                "fontFamily": {
                    "label": "Arial",
                    "value": "arial,helvetica,sans-serif"
                },
                "preheaderText": null,
                "linkStyle": {
                    "body": "true",
                    "linkColor": "#0000ee",
                    "linkHoverColor": "#0000ee",
                    "linkUnderline": "true",
                    "linkHoverUnderline": "true"
                },
                "_meta": {
                    "htmlID": "u_body",
                    "htmlClassNames": "u_body"
                }
            }
        }

    });

</script>
@endsection