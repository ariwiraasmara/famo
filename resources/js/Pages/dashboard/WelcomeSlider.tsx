import React, { useState, useEffect, useRef } from "react";
import "./carousel.css";

export default function WelcomeSlider({ images, captions }) {

    const [currentSlide, setCurrentSlide] = useState(1);
    const carouselRef = useRef(null);

    const [isLeftOrRight, setIsLeftOrRight] = useState('');

    const goToNextSlide = () => {
        setCurrentSlide(prevSlide => (prevSlide % 5) + 1);
        setIsLeftOrRight('w3-animate-right');
    };
      
    const goToPrevSlide = () => {
        setCurrentSlide(prevSlide => (prevSlide - 2 + 5) % 5 + 1);
        setIsLeftOrRight('w3-animate-left');
    };
      

    useEffect(() => {
        const interval = setInterval(goToNextSlide, 3000);
        return () => clearInterval(interval);
    }, []);

    return (
        <div className="slides-container">
            <div className="carousel" ref={carouselRef}>
                <div className={`slide-item ${currentSlide === 1 ? 'active ' + isLeftOrRight : 'slide'}`}><img src={images[0]} title={captions[0]}/></div>
                <div className={`slide-item ${currentSlide === 2 ? 'active ' + isLeftOrRight : 'slide'}`}><img src={images[1]} title={captions[1]}/></div>
                <div className={`slide-item ${currentSlide === 3 ? 'active ' + isLeftOrRight : 'slide'}`}><img src={images[2]} title={captions[2]}/></div>
                <div className={`slide-item ${currentSlide === 4 ? 'active ' + isLeftOrRight : 'slide'}`}><img src={images[3]} title={captions[3]}/></div>
                <div className={`slide-item ${currentSlide === 5 ? 'active ' + isLeftOrRight : 'slide'}`}><img src={images[4]} title={captions[4]}/></div>
            </div>
            <button type="button" className="slide-button prev-button" role="button" onClick={goToPrevSlide}>
                <ion-icon name="chevron-back-outline" size="large"></ion-icon>
            </button>
            <button type="button" className="slide-button next-button" role="button" onClick={goToNextSlide}>
                <ion-icon name="chevron-forward-outline" size="large"></ion-icon>
            </button>
        </div>
    );
};
