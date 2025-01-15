import { images, captions, elementTrigger, submitLogin, submitRegister } from './ext_welcome.ts';
import { Head } from '@inertiajs/react';
import Navbar from '../Components/Navbar';
import Slider from './dashboard/WelcomeSlider';
// import { useDispatch } from 'react-redux';
import { block, For } from 'million/react';

export default function Welcome(islogin) {
    // const dispatch = useDispatch();
    // const handleLogin = () => {
    //     const userlogin = $('#user-login').val();
    //     const passlogin = $('#pass-login').val();
    //     // dispatch(submitLogin(userlogin, passlogin));
    // };
    elementTrigger();

    const BlockHeadtitle = block(function Lion() {
        return <Head title="Welcome" />;
    });

    const BlockSlider = block(function Lion() {
        return <Slider images={images} captions={captions} />;
    });

    return (
        <>
            <BlockHeadtitle />
            <Navbar isLogin={false} title="Welcome" username={null} notifications={[null]} nav_active={null} />

            <BlockSlider />

            <div className="modal" id="modal-login">
                <div className="modal-background close-modal-login"></div>
                <div className="modal-card">
                    <header className="modal-card-head">
                        <p className="modal-card-title center">
                            <h1 className="title bold">Login</h1>
                        </p>
                        <button className="delete close-modal-login" aria-label="close"></button>
                    </header>
                    <section className="modal-card-body">
                        <div className="control has-icons-left">
                            <input type="text" name="user-login" id="user-login" className="input is-rounded" placeholder="Username / Email.." required />
                            <span className="icon is-small is-left">
                                <ion-icon name="person-outline"></ion-icon>
                            </span>
                        </div>

                        <div className="control has-icons-left m-t-10">
                            <input type="password" name="pass-login" id="pass-login" className="input is-rounded" placeholder="Password.." required />
                            <span className="icon is-small is-left">
                                <ion-icon name="lock-closed-outline"></ion-icon>
                            </span>
                        </div>

                        <button type="button" id="submit-login" title="Login"
                                className="button m-t-10 is-link is-rounded is-fullwidth"
                                onClick={()=>submitLogin()}>
                            <ion-icon name="log-in-outline" size="large"></ion-icon>
                        </button>
                    </section>
                </div>
            </div>

            <div className="modal" id="modal-register">
                <div className="modal-background close-modal-register"></div>
                <div className="modal-card">
                    <header className="modal-card-head">
                        <p className="modal-card-title center">
                            <h1 className="title bold">Register</h1>
                        </p>
                        <button className="delete close-modal-register" aria-label="close"></button>
                    </header>
                    <section className="modal-card-body">
                        <div className="control has-icons-left">
                            <input type="text" name="user-register" id="user-register" className="input is-rounded" placeholder="Username.." required />
                            <span className="icon is-small is-left">
                                <ion-icon name="person-outline"></ion-icon>
                            </span>
                        </div>

                        <div className="control has-icons-left m-t-10">
                            <input type="email" name="email-register" id="email-register" className="input is-rounded" placeholder="Email.." required />
                            <span className="icon is-small is-left">
                                <ion-icon name="mail-outline"></ion-icon>
                            </span>
                        </div>

                        <div className="control has-icons-left m-t-10">
                            <input type="password" name="pass-register" id="pass-register" className="input is-rounded" placeholder="Password.." required />
                            <span className="icon is-small is-left">
                                <ion-icon name="lock-closed-outline"></ion-icon>
                            </span>
                        </div>

                        <div className="control has-icons-left m-t-10">
                            <input type="password" name="repass-register" id="repass-register" className="input is-rounded" placeholder="Repeat Password.." required />
                            <span className="icon is-small is-left">
                                <ion-icon name="lock-closed-outline"></ion-icon>
                            </span>
                        </div>

                        <button type="button" id="submit-register" title="Save"
                                className="button m-t-10 is-link is-rounded is-fullwidth"
                                onClick={()=>submitRegister()}>
                            <ion-icon name="save-outline" size="large"></ion-icon>
                        </button>
                    </section>
                </div>
            </div>
        </>
    );
}
