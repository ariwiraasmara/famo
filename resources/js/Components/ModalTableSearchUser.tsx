export default function ModalTableSearchUser({ name, title }) {
    
    $('.close-modal-'+name).click(function(){
        $('#modal-'+name).removeClass('is-active');
    });

    return (
        <div className="modal" id={`modal-${name}`}>
            <div className={`modal-background close-modal-${name}`}></div>
            <div className="modal-card">
                <header className="modal-card-head">
                    <p className="modal-card-title">
                        <h1 className="title">{title}</h1>
                    </p>
                    <button className={`delete close-modal-${name}`} aria-label="close"></button>
                </header>
                <section className="modal-card-body">
                    <div className="control">
                        <input type="text" className="input is-rounded is-fullwidth" id="searchuser" name="searchuser"  placeholder="Name.." />
                    </div>

                    <table className="m-t-10 table is-mobile is-fullwidth text-is-black">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody id="searchbody"></tbody>
                    </table>
                </section>
            </div>
        </div>
    )
}