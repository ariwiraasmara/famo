export default function ModalMM({ name, title, slot }) {

    $('.close-modal-'+name).click(function(){
        $('#modal-'+name).removeClass('is-active');
    });

    return(
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
                    {slot}
                </section>
            </div>
        </div>
    )

}
