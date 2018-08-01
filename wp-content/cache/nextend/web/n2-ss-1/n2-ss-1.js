(function ($, scope, undefined) {
    function NextendSmartSliderWidgetArrowImage(id, desktopRatio, tabletRatio, mobileRatio) {
        this.slider = window[id];

        this.slider.started($.proxy(this.start, this, id, desktopRatio, tabletRatio, mobileRatio));
    };

    NextendSmartSliderWidgetArrowImage.prototype.start = function (id, desktopRatio, tabletRatio, mobileRatio) {
        if (this.slider.sliderElement.data('arrow')) {
            return false;
        }
        this.slider.sliderElement.data('arrow', this);

        this.deferred = $.Deferred();

        this.slider.sliderElement
            .on('SliderDevice', $.proxy(this.onDevice, this))
            .trigger('addWidget', this.deferred);

        this.previous = $('#' + id + '-arrow-previous').on('click', $.proxy(function (e) {
            e.stopPropagation();
            this.slider.previous();
        }, this));

        this.previousResize = this.previous.find('.n2-resize');
        if (this.previousResize.length == 0) {
            this.previousResize = this.previous;
        }


        this.next = $('#' + id + '-arrow-next').on('click', $.proxy(function (e) {
            e.stopPropagation();
            this.slider.next();
        }, this));

        this.nextResize = this.next.find('.n2-resize');
        if (this.nextResize.length == 0) {
            this.nextResize = this.next;
        }

        this.desktopRatio = desktopRatio;
        this.tabletRatio = tabletRatio;
        this.mobileRatio = mobileRatio;

        $.when(this.previous.imagesLoaded(), this.next.imagesLoaded()).always($.proxy(this.loaded, this));
    };

    NextendSmartSliderWidgetArrowImage.prototype.loaded = function () {
        this.previousWidth = this.previousResize.width();
        this.previousHeight = this.previousResize.height();

        this.nextWidth = this.nextResize.width();
        this.nextHeight = this.nextResize.height();
        this.onDevice(null, {device: this.slider.responsive.getDeviceMode()});

        this.deferred.resolve();
    };

    NextendSmartSliderWidgetArrowImage.prototype.onDevice = function (e, device) {
        var ratio = 1;
        switch (device.device) {
            case 'tablet':
                ratio = this.tabletRatio;
                break;
            case 'mobile':
                ratio = this.mobileRatio;
                break;
            default:
                ratio = this.desktopRatio;
        }
        this.previousResize.width(this.previousWidth * ratio);
        this.previousResize.height(this.previousHeight * ratio);
        this.nextResize.width(this.nextWidth * ratio);
        this.nextResize.height(this.nextHeight * ratio);
    };


    scope.NextendSmartSliderWidgetArrowImage = NextendSmartSliderWidgetArrowImage;
})(n2, window);
(function ($, scope, undefined) {
    "use strict";
    function NextendSmartSliderWidgetBarHorizontal(id, bars, parameters) {
        this.slider = window[id];

        this.slider.started($.proxy(this.start, this, id, bars, parameters));
    };

    NextendSmartSliderWidgetBarHorizontal.prototype.start = function (id, bars, parameters) {
        if (this.slider.sliderElement.data('bar')) {
            return false;
        }
        this.slider.sliderElement.data('bar', this);

        this.offset = 0;
        this.tween = null;

        this.originalBars = this.bars = bars;
        this.bar = this.slider.sliderElement.find('.nextend-bar');
        this.innerBar = this.bar.find('> div');

        this.slider.sliderElement.on('slideCountChanged', $.proxy(this.onSlideCountChanged, this));

        if (parameters.animate) {
            this.slider.sliderElement.on('mainAnimationStart', $.proxy(this.onSliderSwitchToAnimateStart, this));
        } else {
            this.slider.sliderElement.on('sliderSwitchTo', $.proxy(this.onSliderSwitchTo, this));
        }

        if (parameters.overlay == 0) {
            var side = false;
            switch (parameters.area) {
                case 1:
                    side = 'Top';
                    break;
                case 12:
                    side = 'Bottom';
                    break;
            }
            if (side) {
                this.offset = parseFloat(this.bar.data('offset'));
                this.slider.responsive.addStaticMargin(side, this);
            }
        }
    };

    NextendSmartSliderWidgetBarHorizontal.prototype.onSliderSwitchTo = function (e, targetSlideIndex) {
        this.innerBar.html(this.bars[targetSlideIndex]);
    };

    NextendSmartSliderWidgetBarHorizontal.prototype.onSliderSwitchToAnimateStart = function () {
        var deferred = $.Deferred();
        this.slider.sliderElement.on('mainAnimationComplete.n2Bar', $.proxy(this.onSliderSwitchToAnimateEnd, this, deferred));
        if (this.tween) {
            this.tween.pause();
        }
        NextendTween.to(this.innerBar, 0.3, {
            opacity: 0,
            onComplete: function () {
                deferred.resolve();
            }
        }).play();
    };

    NextendSmartSliderWidgetBarHorizontal.prototype.onSliderSwitchToAnimateEnd = function (deferred, e, animation, currentSlideIndex, targetSlideIndex) {
        this.slider.sliderElement.off('.n2Bar');
        deferred.done($.proxy(function () {
            var innerBar = this.innerBar.clone();
            this.innerBar.remove();
            this.innerBar = innerBar.css('opacity', 0)
                .html(this.bars[targetSlideIndex])
                .appendTo(this.bar);

            this.tween = NextendTween.to(this.innerBar, 0.3, {
                opacity: 1
            }).play();
        }, this));
    };

    NextendSmartSliderWidgetBarHorizontal.prototype.isVisible = function () {
        return this.bar.is(':visible');
    };

    NextendSmartSliderWidgetBarHorizontal.prototype.getSize = function () {
        return this.bar.height() + this.offset;
    };

    NextendSmartSliderWidgetBarHorizontal.prototype.onSlideCountChanged = function (e, newCount, slidesInGroup) {
        this.bars = [];
        for (var i = 0; i < this.originalBars.length; i++) {
            if (i % slidesInGroup == 0) {
                this.bars.push(this.originalBars[i]);
            }
        }
    };

    scope.NextendSmartSliderWidgetBarHorizontal = NextendSmartSliderWidgetBarHorizontal;
})(n2, window);
(function ($, scope, undefined) {
    function NextendSmartSliderWidgetBulletTransition(id, parameters) {

        this.slider = window[id];

        this.slider.started($.proxy(this.start, this, id, parameters));
    };

    NextendSmartSliderWidgetBulletTransition.prototype.start = function (id, parameters) {

        if (this.slider.sliderElement.data('bullet')) {
            return false;
        }
        this.slider.sliderElement.data('bullet', this);

        this.axis = 'horizontal';
        this.offset = 0;
        this.parameters = parameters;

        this.bar = this.slider.sliderElement.find('.nextend-bullet-bar');

        var event = 'universalclick';
        if (parameters.action == 'mouseenter') {
            event = 'mouseenter';
        }
        this.originalDots = this.dots = this.bar.find('div').on(event, $.proxy(this.onDotClick, this));
        this.slider.sliderElement
            .on('slideCountChanged', $.proxy(this.onSlideCountChanged, this))
            .on('sliderSwitchTo', $.proxy(this.onSlideSwitch, this));

        if (parameters.overlay == 0) {
            var side = false;
            switch (parameters.area) {
                case 1:
                    side = 'Top';
                    break;
                case 12:
                    side = 'Bottom';
                    break;
                case 5:
                    side = 'Left';
                    this.axis = 'vertical';
                    break;
                case 8:
                    side = 'Right';
                    this.axis = 'vertical';
                    break;
            }
            if (side) {
                this.offset = parseFloat(this.bar.data('offset'));
                this.slider.responsive.addStaticMargin(side, this);
            }
        }

        this.initThumbnails();
    };

    NextendSmartSliderWidgetBulletTransition.prototype.onDotClick = function (e) {
        this.slider.directionalChangeToReal(this.originalDots.index(e.currentTarget));
    };

    NextendSmartSliderWidgetBulletTransition.prototype.onSlideSwitch = function (e, targetSlideIndex) {
        this.dots.filter('.n2-active').removeClass('n2-active');
        this.dots.eq(targetSlideIndex).addClass('n2-active');
    };

    NextendSmartSliderWidgetBulletTransition.prototype.isVisible = function () {
        return this.bar.is(':visible');
    };

    NextendSmartSliderWidgetBulletTransition.prototype.getSize = function () {
        if (this.axis == 'horizontal') {
            return this.bar.height() + this.offset;
        }
        return this.bar.width() + this.offset;
    };

    NextendSmartSliderWidgetBulletTransition.prototype.initThumbnails = function () {
        if (this.parameters.thumbnails.length > 0) {
            this.dots.each($.proxy(function (i, el) {
                if (this.parameters.thumbnails[i] != '') {
                    $(el).on({
                        universalenter: $.proxy(this.showThumbnail, this, i)/*,
                         universalleave: $.proxy(this.hideThumbnail, this, i)*/
                    }, {
                        leaveOnSecond: true
                    })
                }
            }, this));
        }
    };

    NextendSmartSliderWidgetBulletTransition.prototype.showThumbnail = function (i, e) {
        var thumbnail = this.getThumbnail(i);

        NextendTween.to(thumbnail, 0.3, {
            opacity: 1
        }).play();

        this.originalDots.eq(i).on('universalleave', $.proxy(this.hideThumbnail, this, thumbnail));
    };

    NextendSmartSliderWidgetBulletTransition.prototype.hideThumbnail = function (thumbnail, e) {
        e.stopPropagation();
        NextendTween.to(thumbnail, 0.3, {
            opacity: 0,
            onComplete: function () {
                thumbnail.remove();
            }
        }).play();
    };

    NextendSmartSliderWidgetBulletTransition.prototype.getThumbnail = function (i) {
        var target = this.originalDots.eq(i);
        var targetOffset = target.offset(),
            targetW = target.outerWidth(),
            targetH = target.outerHeight();

        var thumbnail = $('<div/>').append($('<div/>').css({
            width: this.parameters.thumbnailWidth,
            height: this.parameters.thumbnailHeight,
            backgroundImage: 'url("' + this.parameters.thumbnails[i] + '")',
            backgroundSize: 'inherit',
            backgroundRepeat: 'no-repeat',
            backgroundPosition: 'center'
        }).addClass('n2-bullet-thumbnail'))
            .addClass(this.parameters.thumbnailStyle)
            .addClass('n2-bullet-thumbnail-container')
            .css({
                position: 'absolute',
                opacity: 0,
                zIndex: 10000000
            }).appendTo('body');

        switch (this.parameters.thumbnailPosition) {
            case 'right':
                thumbnail.css({
                    left: targetOffset.left + targetW,
                    top: targetOffset.top + targetH / 2 - thumbnail.outerHeight(true) / 2
                });
                break;
            case 'left':
                thumbnail.css({
                    left: targetOffset.left - thumbnail.outerWidth(true),
                    top: targetOffset.top + targetH / 2 - thumbnail.outerHeight(true) / 2
                });
                break;
            case 'top':
                thumbnail.css({
                    left: targetOffset.left + targetW / 2 - thumbnail.outerWidth(true) / 2,
                    top: targetOffset.top - thumbnail.outerHeight(true)
                });
                break;
            case 'bottom':
                thumbnail.css({
                    left: targetOffset.left + targetW / 2 - thumbnail.outerWidth(true) / 2,
                    top: targetOffset.top + targetH
                });
                break;
        }

        target.data('thumbnail', thumbnail);
        return thumbnail;
    };

    NextendSmartSliderWidgetBulletTransition.prototype.onSlideCountChanged = function (e, newCount, slidesInGroup) {
        this.dots = $();
        for (var i = 0; i < this.originalDots.length; i++) {
            if (i % slidesInGroup == 0) {
                this.dots = this.dots.add(this.originalDots.eq(i).css("display", ""));
            } else {
                this.originalDots.eq(i).css("display", "none");
            }
        }
        if (this.parameters.numeric) {
            this.dots.each(function (i, el) {
                el.innerHTML = i + 1;
            });
        }
    };

    scope.NextendSmartSliderWidgetBulletTransition = NextendSmartSliderWidgetBulletTransition;
})(n2, window);
(function ($, scope, undefined) {
    "use strict";

    function NextendSmartSliderWidgetShadow(id, parameters) {
        this.slider = window[id];

        this.slider.started($.proxy(this.start, this, id, parameters));
    };


    NextendSmartSliderWidgetShadow.prototype.start = function (id, parameters) {
        this.shadow = this.slider.sliderElement.find('.nextend-shadow');
        this.slider.responsive.addStaticMargin('Bottom', this);
    };

    NextendSmartSliderWidgetShadow.prototype.isVisible = function () {
        return this.shadow.is(':visible');
    };

    NextendSmartSliderWidgetShadow.prototype.getSize = function () {
        return this.shadow.height();
    };

    scope.NextendSmartSliderWidgetShadow = NextendSmartSliderWidgetShadow;
})(n2, window);
(function ($, scope, undefined) {
    "use strict";
    function NextendSmartSliderWidgetThumbnailDefault(id, parameters) {

        this.slider = window[id];

        this.slider.started($.proxy(this.start, this, id, parameters));
    };


    NextendSmartSliderWidgetThumbnailDefault.prototype.start = function (id, parameters) {

        if (this.slider.sliderElement.data('thumbnail')) {
            return false;
        }
        this.slider.sliderElement.data('thumbnail', this);

        this.parameters = $.extend({captionSize: 0, minimumThumbnailCount: 1.5}, parameters);

        this.ratio = 1;
        this.hidden = false;
        this.forceHidden = false;
        this.forceHiddenCB = null;
        this.group = 2;
        this.itemPerPane = 1;
        this.currentI = 0;
        this.offset = 0;
        this.horizontal = {
            prop: 'width',
            Prop: 'Width',
            sideProp: 'left',
            invProp: 'height'
        };
        this.vertical = {
            prop: 'height',
            Prop: 'Height',
            sideProp: 'top',
            invProp: 'width'
        };

        this.group = parseInt(parameters.group);
        this.orientation = parameters.orientation;
        if (this.orientation == 'vertical') {
            this.goToDot = this._goToDot;
        }

        this.outerBar = this.slider.sliderElement.find('.nextend-thumbnail-default');
        this.bar = this.outerBar.find('.nextend-thumbnail-inner');
        this.scroller = this.bar.find('.nextend-thumbnail-scroller');

        var event = 'universalclick';
        if (parameters.action == 'mouseenter') {
            event = 'mouseenter';
        }
        this.dots = this.scroller.find('td > div').on(event, $.proxy(this.onDotClick, this));
        this.images = this.dots.find('.n2-ss-thumb-image');

        this.previous = this.outerBar.find('.nextend-thumbnail-previous').on('click', $.proxy(this.previousPane, this));
        this.next = this.outerBar.find('.nextend-thumbnail-next').on('click', $.proxy(this.nextPane, this));

        if (this.orientation == 'horizontal' && this.group > 1) {
            var dots = [],
                group = this.group;
            this.scroller.find('tr').each(function (i, tr) {
                $(tr).find('td > div').each(function (j, div) {
                    dots[i + j * group] = div;
                });
            });
            this.dots = $(dots);
        }


        this.scrollerDimension = {
            width: this.scroller.width(),
            height: this.scroller.width()
        };
        this.thumbnailDimension = {
            width: this.dots.outerWidth(true),
            height: this.dots.outerHeight(true)
        };

        this.thumbnailDimension.widthMargin = this.thumbnailDimension.width - this.dots.outerWidth();
        this.thumbnailDimension.heightMargin = this.thumbnailDimension.height - this.dots.outerHeight();

        this.imageDimension = {
            width: this.images.outerWidth(true),
            height: this.images.outerHeight(true)
        };

        this.sideDimension = this.thumbnailDimension[this[this.orientation].prop] * 0.25;

        if (this.orientation == 'horizontal') {
            this.scroller.height(this.thumbnailDimension.height * this.group);
            this.bar.height(this.scroller.outerHeight(true));
        } else {
            this.scroller.width(this.thumbnailDimension.width * this.group);
            this.bar.width(this.scroller.outerWidth(true));
        }
        //this.onSliderResize();

        this.slider.sliderElement
            .on('BeforeVisible', $.proxy(this.onReady, this))
            .on('sliderSwitchTo', $.proxy(this.onSlideSwitch, this));

        if (parameters.overlay == 0) {
            var side = false;
            switch (parameters.area) {
                case 1:
                    side = 'Top';
                    break;
                case 12:
                    side = 'Bottom';
                    break;
                case 5:
                    side = 'Left';
                    break;
                case 8:
                    side = 'Right';
                    break;
            }
            if (side) {
                this.offset = parseFloat(this.outerBar.data('offset'));
                this.slider.responsive.addStaticMargin(side, this);
            }
        }
    };

    NextendSmartSliderWidgetThumbnailDefault.prototype.onReady = function () {
        this.slider.sliderElement.on('SliderResize', $.proxy(this.onSliderResize, this));
        this.onSliderResize();
    };


    NextendSmartSliderWidgetThumbnailDefault.prototype.onSliderResize = function () {
        if (this.forceHiddenCB !== null) {
            this.forceHiddenCB.call(this);
        }
        this.adjustScrollerSize();

        this.goToDot(this.dots.index(this.dots.filter('.n2-active')));
    };

    NextendSmartSliderWidgetThumbnailDefault.prototype.adjustScrollerSize = function () {
        var prop = this[this.orientation].prop,
            size = Math.ceil(this.dots.length / this.group) * this.thumbnailDimension[prop] * this.ratio,
            diff = this.scroller['outer' + this[this.orientation].Prop]() - this.scroller[prop](),
            barDimension = this.slider.dimensions['thumbnail' + prop];
        if (size + diff <= barDimension) {
            this.scroller[prop](barDimension - diff);
        } else {
            this.scroller[prop](size);
        }

    };

    NextendSmartSliderWidgetThumbnailDefault.prototype.onDotClick = function (e) {
        this.slider.directionalChangeToReal(this.dots.index(e.currentTarget));
    };

    NextendSmartSliderWidgetThumbnailDefault.prototype.onSlideSwitch = function (e, targetSlideIndex, realTargetSlideIndex) {
        this.dots.filter('.n2-active').removeClass('n2-active');
        this.dots.eq(realTargetSlideIndex).addClass('n2-active');

        this.goToDot(realTargetSlideIndex);

    };

    NextendSmartSliderWidgetThumbnailDefault.prototype.previousPane = function () {
        this.goToDot(this.currentI - this.itemPerPane);
    };

    NextendSmartSliderWidgetThumbnailDefault.prototype.nextPane = function () {
        this.goToDot(this.currentI + this.itemPerPane);
    };

    NextendSmartSliderWidgetThumbnailDefault.prototype.goToDot = function (i) {

        var variables = this[this.orientation],
            ratio = 1,
            barDimension = this.slider.dimensions['thumbnail' + variables.prop],
            sideDimension = this.sideDimension,
            availableBarDimension = barDimension - sideDimension * 2,
            itemPerPane = availableBarDimension / this.thumbnailDimension[variables.prop];
        if (itemPerPane <= this.parameters.minimumThumbnailCount) {
            sideDimension = barDimension * 0.1;
            availableBarDimension = barDimension - sideDimension * 2;
            ratio = availableBarDimension / (this.parameters.minimumThumbnailCount * this.thumbnailDimension[variables.prop]);
            itemPerPane = availableBarDimension / (this.thumbnailDimension[variables.prop] * ratio);
        }

        if (this.ratio != ratio) {
            var css = {};
            css[variables.prop] = parseInt(this.thumbnailDimension[variables.prop] * ratio - this.thumbnailDimension[variables.prop + 'Margin']);
            var scrollerDimension = css[variables.invProp] = parseInt((this.thumbnailDimension[variables.invProp] - this.parameters['captionSize']) * ratio + this.parameters['captionSize']);
            this.dots.css(css);
            css = {};
            css[variables.prop] = parseInt(this.imageDimension[variables.prop] * ratio - this.thumbnailDimension[variables.prop + 'Margin']);
            css[variables.invProp] = parseInt(this.imageDimension[variables.invProp] * ratio);
            this.images.css(css);

            this.scroller.css(variables.invProp, 'auto');
            this.bar.css(variables.invProp, 'auto');
            this.ratio = ratio;
            this.slider.responsive.doNormalizedResize();

            this.adjustScrollerSize();
        }

        itemPerPane = Math.floor(itemPerPane);
        i = Math.max(0, Math.min(this.dots.length - 1, i));
        var currentPane = Math.floor(i / this.group / itemPerPane),
            to = {};

        var min = -(this.scroller['outer' + variables.Prop]() - barDimension);

        if (currentPane == Math.floor((this.dots.length - 1) / this.group / itemPerPane)) {
            to[variables.sideProp] = -(currentPane * itemPerPane * this.thumbnailDimension[variables.prop] * ratio);
            if (currentPane == 0) {
                this.previous.removeClass('n2-active');
            } else {
                this.previous.addClass('n2-active');
            }
            this.next.removeClass('n2-active');
        } else if (currentPane > 0) {
            to[variables.sideProp] = -(currentPane * itemPerPane * this.thumbnailDimension[variables.prop] * ratio - sideDimension);
            this.previous.addClass('n2-active');
            this.next.addClass('n2-active');
        } else {
            to[variables.sideProp] = 0;
            this.previous.removeClass('n2-active');
            this.next.addClass('n2-active');
        }
        if (min >= to[variables.sideProp]) {
            to[variables.sideProp] = min;
            this.next.removeClass('n2-active');
        }
        NextendTween.to(this.scroller, 0.5, to).play();


        this.currentI = i;
        this.itemPerPane = itemPerPane;

    };

    NextendSmartSliderWidgetThumbnailDefault.prototype._goToDot = function (i) {
        if (this.forceHidden) {
            return;
        }
        var variables = this[this.orientation];
        var barDimension = this.slider.dimensions['thumbnail' + variables.prop];


        var itemPerPane = (barDimension - this.sideDimension * 2) / this.thumbnailDimension[variables.prop];
        if (barDimension != 0 && itemPerPane < this.parameters.minimumThumbnailCount - 0.5) {
            if (!this.hidden) {
                if (this.orientation == 'horizontal') {
                    this.outerBar.css('height', 0);
                } else {
                    this.outerBar.css('width', 0);
                }
                this.hidden = true;
                this.forceHidden = true;
                setTimeout($.proxy(function () {
                    this.forceHiddenCB = function () {
                        this.forceHiddenCB = null;
                        this.forceHidden = false;
                    };
                }, this), 300);
                this.slider.responsive.doNormalizedResize();
            }
        } else if (this.hidden) {
            if (itemPerPane >= this.parameters.minimumThumbnailCount + 0.5) {
                this.hidden = false;
                if (this.orientation == 'horizontal') {
                    this.outerBar.css('height', '');
                } else {
                    this.outerBar.css('width', '');
                }
                this.slider.responsive.doNormalizedResize();
            }
        }

        if (!this.hidden) {
            itemPerPane = Math.floor(itemPerPane);
            i = Math.max(0, Math.min(this.dots.length - 1, i));
            var currentPane = Math.floor(i / this.group / itemPerPane),
                to = {};

            var min = -(this.scroller['outer' + variables.Prop]() - barDimension);

            if (currentPane == Math.floor((this.dots.length - 1) / this.group / itemPerPane)) {
                to[variables.sideProp] = -(currentPane * itemPerPane * this.thumbnailDimension[variables.prop]);
                if (currentPane == 0) {
                    this.previous.removeClass('n2-active');
                } else {
                    this.previous.addClass('n2-active');
                }
                this.next.removeClass('n2-active');
            } else if (currentPane > 0) {
                to[variables.sideProp] = -(currentPane * itemPerPane * this.thumbnailDimension[variables.prop] - this.sideDimension);
                this.previous.addClass('n2-active');
                this.next.addClass('n2-active');
            } else {
                to[variables.sideProp] = 0;
                this.previous.removeClass('n2-active');
                this.next.addClass('n2-active');
            }
            if (min >= to[variables.sideProp]) {
                to[variables.sideProp] = min;
                this.next.removeClass('n2-active');
            }
            NextendTween.to(this.scroller, 0.5, to).play();
        }


        this.currentI = i;
        this.itemPerPane = itemPerPane;
    };

    NextendSmartSliderWidgetThumbnailDefault.prototype.isVisible = function () {
        return this.outerBar.is(':visible');
    };

    NextendSmartSliderWidgetThumbnailDefault.prototype.getSize = function () {
        if (this.orientation == 'horizontal') {
            return this.outerBar.height() + this.offset;
        }
        return this.outerBar.width() + this.offset;
    };

    scope.NextendSmartSliderWidgetThumbnailDefault = NextendSmartSliderWidgetThumbnailDefault;

})(n2, window);
