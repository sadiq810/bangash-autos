import React, {Component} from 'react';

class LoaderComponent extends Component {
    constructor(props) {
        super(props);
    }//..... end of constructor() .....//

    render() {
        return (<>
            <div className="preloader loaderContainer"></div>
            <img src={BaseUrl+'/assets/images/loader.gif'} className="loaderImage loaderContainer"/>
        </>);
    }//..... end of render() .....//
}//..... end of LoaderComponent.

export default LoaderComponent;
