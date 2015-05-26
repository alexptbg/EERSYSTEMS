$(document).ready(function(){
        $('.tip').qtip({ style: {name: 'aquarius' },
                        position: {
                            corner: {
                                target: 'bottomMiddle',
                                tooltip: 'topLeft'
                            }
                        },
						hide: { when: 'mouseout', delay: 0 },
						show: { solo: true }
                    });
        $('.tip_').qtip({ style: {name: 'aquarius' },
                        position: {
                            corner: {
                                target: 'bottomMiddle',
                                tooltip: 'topRight'
                            }
                        },
						hide: { when: 'mouseout', delay: 0 },
						show: { solo: true }
                    });
});