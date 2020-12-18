import React, {Component} from 'react';
import "react-responsive-carousel/lib/styles/carousel.min.css";
import { Carousel } from 'react-responsive-carousel';
import {connect} from "react-redux";
import {loadSliderData} from "../../redux/actions/CommonActions";

class HomeSlider extends Component {
    constructor(props) {
        super(props);
    }

    componentDidMount() {
        this.props.loadData();
    }

    render() {
        return (
            (this.props.slider.length > 0 && <Carousel showThumbs={false} autoPlay={true} infiniteLoop={true}>
                {
                    this.props.slider.map(slider => {
                        return (
                            <div key={slider.id}>
                                <img src={BaseUrl+'/slider/'+slider.image} />
                            </div>
                        )
                    })
                }
            </Carousel>)
        );
    }
}


const mapStateToProps = (state) => {
    return {
        slider: state.common.slider
    };
};

const mapDispatchToProps = (dispatch) => {
    return {
        loadData: () => dispatch(loadSliderData()),
    };
};

export default connect(mapStateToProps, mapDispatchToProps)(HomeSlider);
