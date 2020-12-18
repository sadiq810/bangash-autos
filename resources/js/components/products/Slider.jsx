import React, {Component} from 'react';
import "react-responsive-carousel/lib/styles/carousel.min.css";

import ImageGallery from 'react-image-gallery';

class Slider extends Component{
    constructor(props) {
        super(props);
        this.state = {
            showIndex: false,
            showBullets: true,
            infinite: true,
            showThumbnails: true,
            showFullscreenButton: true,
            showGalleryFullscreenButton: true,
            showPlayButton: true,
            showGalleryPlayButton: true,
            showNav: true,
            isRTL: false,
            slideDuration: 450,
            slideInterval: 2000,
            slideOnThumbnailOver: false,
            thumbnailPosition: 'bottom',
            showVideo: {},
        };
    }

    componentDidUpdate(prevProps, prevState) {
        if (this.state.slideInterval !== prevState.slideInterval ||
            this.state.slideDuration !== prevState.slideDuration) {
            // refresh setInterval
            this._imageGallery.pause();
            this._imageGallery.play();
        }

        $('body').find(".block__pic").unbind();
        $('body').find(".block__pic").imagezoomsl({
            zoomrange: [3, 3]
        });
    }

    componentDidMount() {
        $('body').find(".block__pic").imagezoomsl({
            zoomrange: [3, 3]
        });
    }

    _onImageClick(event) {
        console.debug('clicked on image', event.target, 'at index', this._imageGallery.getCurrentIndex());
    }

    _onImageLoad(event) {
        console.debug('loaded image', event.target.src);
    }

    _onSlide(index) {
        this._resetVideo();
        console.debug('slid to index', index);
    }

    _onPause(index) {
        console.debug('paused on index', index);
    }

    _onScreenChange(fullScreenElement) {
        console.debug('isFullScreen?', !!fullScreenElement);
    }

    _onPlay(index) {
        console.debug('playing from index', index);
    }

    _resetVideo() {
        this.setState({showVideo: {}});

        if (this.state.showPlayButton) {
            this.setState({showGalleryPlayButton: true});
        }

        if (this.state.showFullscreenButton) {
            this.setState({showGalleryFullscreenButton: true});
        }
    }

    _toggleShowVideo(url) {
        this.state.showVideo[url] = !Boolean(this.state.showVideo[url]);
        this.setState({
            showVideo: this.state.showVideo
        });

        if (this.state.showVideo[url]) {
            if (this.state.showPlayButton) {
                this.setState({showGalleryPlayButton: false});
            }

            if (this.state.showFullscreenButton) {
                this.setState({showGalleryFullscreenButton: false});
            }
        }
    }

    _renderVideo(item) {
        return (
            <div className='image-gallery-image'>
                {
                    this.state.showVideo[item.embedUrl] ?
                        <div className='video-wrapper'>
                            <a
                                className='close-video'
                                onClick={this._toggleShowVideo.bind(this, item.embedUrl)}
                            >
                            </a>
                            <iframe
                                width='560'
                                height='315'
                                src={item.embedUrl}
                                frameBorder='0'
                                allowFullScreen
                            >
                            </iframe>
                        </div>
                        :
                        <a onClick={this._toggleShowVideo.bind(this, item.embedUrl)}>
                            <div className='play-button'></div>
                            <img src={item.original}/>
                            {
                                item.description &&
                                <span className='image-gallery-description' style={{right: '0', left: 'initial'}}>
                                {item.description}
                              </span>
                            }
                        </a>
                }
            </div>
        );
    }

    _renderImage(item) {
        return (
            <div className='image-gallery-image'>
                <img src={item.original} className={"block__pic"}/>
                {
                    item.description &&
                    <span className='image-gallery-description' style={{right: '0', left: 'initial'}}>
                            {item.description}
                        </span>
                }
            </div>
        );
    }

    render() {
        let images = this.props.product ? this.props.product.image.map(img => {
            return {
                original: `${BaseUrl}/uploads/${img}`,
                thumbnail: `${BaseUrl}/uploads/thumbs/${img}`,
                originalClass: 'featured-slide',
                thumbnailClass: 'featured-thumb',
                description: this.props.product.title,
                renderItem: this._renderImage.bind(this)
            };
        }) : [];

        if (this.props.product && this.props.product.url) {
            images.push({
                thumbnail: `${BaseUrl}/images/video.png`,
                original: `${BaseUrl}/images/video.png`,
                embedUrl: this.props.product.url,
                description: this.props.product.title,
                renderItem: this._renderVideo.bind(this)
            });
        }

        return (
            <section className='app'>
                <ImageGallery
                    ref={i => this._imageGallery = i}
                    items={images}
                    lazyLoad={false}
                    onClick={this._onImageClick.bind(this)}
                    onImageLoad={this._onImageLoad}
                    onSlide={this._onSlide.bind(this)}
                    onPause={this._onPause.bind(this)}
                    onScreenChange={this._onScreenChange.bind(this)}
                    onPlay={this._onPlay.bind(this)}
                    infinite={this.state.infinite}
                    showBullets={this.state.showBullets}
                    showFullscreenButton={this.state.showFullscreenButton && this.state.showGalleryFullscreenButton}
                    showPlayButton={this.state.showPlayButton && this.state.showGalleryPlayButton}
                    showThumbnails={this.state.showThumbnails}
                    showIndex={this.state.showIndex}
                    showNav={this.state.showNav}
                    isRTL={this.state.isRTL}
                    thumbnailPosition={this.state.thumbnailPosition}
                    slideDuration={parseInt(this.state.slideDuration)}
                    slideInterval={parseInt(this.state.slideInterval)}
                    slideOnThumbnailOver={this.state.slideOnThumbnailOver}
                    additionalClass="app-image-gallery"
                />
            </section>
        );
    }
}//..... end of HomeSlider.

export default Slider;
