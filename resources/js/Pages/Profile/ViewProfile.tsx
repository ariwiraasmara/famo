import './style.css';
import { elementTrigger, getAllFile, submitFile, deleteFile } from './external_function.ts';
import { Head } from '@inertiajs/react';
import React, { useState, useEffect, useRef, useMemo } from "react";
import Navbar from '../../Components/Navbar';
import { block, For } from 'million/react';

export default function ViewProfile({ isLogin, profile, path, allfile, notif }) {

    console.log('path', path);
    elementTrigger();
    if(profile[0]['remember_token'] === null) profile[0]['remember_token'] = '__none__';

    const memoProfile:any = useMemo(
        () => [
            profile[0]['id'],
            profile[0]['name'],
            profile[0]['email'],
            profile[0]['remember_token'],
        ], 
        [
            profile[0]['id'],
            profile[0]['name'],
            profile[0]['email'],
            profile[0]['remember_token'],
        ]);

    const [files, setFiles] = useState([]);
    const memoFiles:any = useMemo(() => {
        const cache = files;
        return cache;
    }, [files]);

    const [modaltitle, setModaltitle] = useState('');
    const [getimage, setGetimage] = useState('');
    const [file, setFile] = useState(null);
    const memoModalviewfile:any = useMemo(
        () => [modaltitle,getimage,file], 
        [modaltitle,getimage,file]
    );

    const handleFileChange = (event) => {
        if (event.target.files && event.target.files[0]) {
            setFile(event.target.files[0]);
        }
    };
    // console.log('path', path);

    function openModal(event: any, hfile: String) {
        event.preventDefault();

        $(`#modal-viewfile`).addClass('is-active');
        setModaltitle(hfile);
        setGetimage(path + hfile);
        console.log(getimage);
    }

    $('.close-modal-viewfile').click(function(){
        $('#modal-viewfile').removeClass('is-active');
    });

    const BlockHeadtitle = block(function Lion() {
        return <Head title={`${profile[0]['name']}'s Profile`} />;
    });

    async function viewAllFile() {
        try {
            const response:any = await getAllFile(profile[0].id);
            // setVfiles();
            setFiles(response.data.data);
        } catch (error:any) {
            console.log('Error:', error.message);
        }
    }

    useEffect(() => {
        viewAllFile();
        // setInterval(() => viewAllFile(), 2000);
        // setInterval(() => setFiles(allfile), 2000);
    }, []);

    return (
        <>
            <BlockHeadtitle />
            <Navbar isLogin={isLogin} title="Profile" username={memoProfile[1]} notifications={notif} />

            <div className="p-30 text-is-black">
                <span className="bold">Nama :</span> {memoProfile[1]}<br/>
                <span className="bold">Email :</span> {memoProfile[2]}<br/>
                <span className="bold">Token :</span> {memoProfile[3]}

                <div className="m-t-10">
                    <span className="bold underline">Files</span>
                </div>

                <div className="right">
                    <button type="button" className="button fab is-link" id="btn-modal-addfile">
                        <ion-icon name="add-outline" className="text-is-white" size="large"></ion-icon>
                    </button>
                </div>

                <div className="m-t-10">
                    {memoFiles.length > 0 ? (
                        <For each={memoFiles} memo>{(body:any, index:number) => 
                            <div className="m-t-10">
                                <div className="columns is-mobile row-line">
                                    <div className="column is-9 word-wrap">
                                        <span className="bold" onClick={(event) => openModal(event, body.foto)}>{body.foto}</span><br/>
                                        <span>{body.ket}</span>
                                    </div>
                                    <div className="column is-3">
                                        <button type="button" id={`btn-delete-file-${index}`}
                                                className="button is-warning is-large is-fullwidth is-rounded"
                                                onClick={() => deleteFile(memoProfile[2], body.id, body.foto)}>
                                            <ion-icon name="trash-outline" size="large"></ion-icon>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        }</For>
                    ) : (<div className="">No File</div>)}
                </div>
            </div>

            <div className="modal txt-is-black" id="modal-addfile">
                <div className="modal-background close-modal-addfile"></div>
                <div className="modal-card">
                    <header className="modal-card-head">
                        <p className="modal-card-title center">
                            <h1 className="title bold text-is-black">Add File</h1>
                        </p>
                        <button className="delete close-modal-addfile" aria-label="close"></button>
                    </header>

                    <section className="modal-card-body text-is-black">
                        <span className="bold italic text-is-black">* Only PDF and Images (jpg, png) File with size 1 MB</span>
                        <div className="file has-name is-boxed is-fullwidth txt-is-black">
                            <label className="file-label">
                                <input className="file-input" type="file" name="file" id="file" accept=".pdf, image/jpeg, image/jpg, image/png" onChange={handleFileChange} />
                                <span className="file-cta">
                                    <span className="file-icon">
                                        <ion-icon name="cloud-upload-outline"></ion-icon>
                                    </span>
                                    <span className="file-label center">
                                        Choose a file…
                                    </span>
                                </span>
                                <span className="file-name">

                                </span>
                            </label>
                        </div>
                        <input type="text" className="input is-rounded is-fullwidth m-t-10" id="fileket" name="fileket"  placeholder="Information.." />
                        <div className="m-t-10">
                            <button type="button" id="btn-submit-file"
                                    className="button is-info is-fullwidth"
                                    onClick={() => submitFile(memoProfile[0], memoProfile[2], file)}>
                                <ion-icon name="checkmark-outline" size="large"></ion-icon>
                            </button>
                        </div>
                    </section>
                </div>
            </div>

            <div className="modal" id="modal-viewfile">
                <div className={`modal-background close-modal-viewfile`}></div>
                <div className="modal-card">
                    <header className="modal-card-head">
                        <p className="modal-card-title">
                            <h1 className="title text-is-black">{memoModalviewfile[0]}</h1>
                        </p>
                        <button className={`delete close-modal-viewfile`} aria-label="close"></button>
                    </header>
                    <section className="modal-card-body">
                        <img src={memoModalviewfile[1]} />
                    </section>
                </div>
            </div>
        </>
    );
}
