export default function FloatingActionButton({ name }) {

    $('#btn-'+name).click(function(){
        $('#modal-'+name).addClass('is-active');
    });

    return(
        <div className="right">
            <button type="button" className="button fab is-link" id={`btn-${name}`}>
                <ion-icon name="add-outline" className="text-is-white" size="large"></ion-icon>
            </button>
        </div>
    )

}